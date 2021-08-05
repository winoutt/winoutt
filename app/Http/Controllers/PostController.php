<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\PostContent;
use App\Repositories\PostHashtagRepository;
use App\Repositories\PostMentionRepository;
use App\Repositories\PostRepository;
use App\Services\ACM;
use App\Services\NotificationService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\File\PostFile;
use App\Services\ImageResize;
use App\Services\MediaValidateRule;
use App\Services\OpenGraph;
use Throwable;

class PostController extends Controller
{
    private $postRepository;
    private $postMentionRepository;
    private $postHashtagRepository;
    private $mediaValidateRule;

    function __construct()
    {
        $this->postRepository = new PostRepository;
        $this->postMentionRepository = new PostMentionRepository;
        $this->postHashtagRepository = new PostHashtagRepository;
        $this->mediaValidateRule = new MediaValidateRule;
    }

    public function create(Request $request)
    {
        $valid = (object) [
            'types' => implode(',', PostContent::$types) . ',poll' . ',text'
        ];
        ValidatorService::validate($request, [
            'teamId' => 'required|exists:teams,id',
            'type' => 'required|in:' . $valid->types
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        if ($request->type === 'text') {
            ValidatorService::validate($request, [
                'caption' => 'required|max:500'
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        } else if ($request->type === 'article') {
            $content = $request->body;
            $request->merge(['body' => strip_tags($content)]);
            ValidatorService::validate($request, [
                'caption' => 'nullable|max:500',
                'body' => 'required|max:55000',
                'cover' => 'nullable|base64file|base64mimes:jpeg,jpg,png|base64max:' . 3 * 1024,
                'extension' => 'required_with:cover'
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
            $request->merge(['body' => $content]);
        }
        else if ($request->type === 'poll') {
            ValidatorService::validate($request, [
                'caption' => 'nullable|max:500',
                'question' => 'required',
                'choices' => 'required|array|min:2,|max:5',
                'endAt' => 'required|date|after:now'
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        } else if ($request->type === 'album') {
            ValidatorService::validate($request, [
                'caption' => 'nullable|max:500',
                'photos' => 'required|array|min:2|max:20',
                'photos.*.file' => 'required|string',
                'photos.*.filename' => 'required|string',
                'photos.*.extension' => 'required|string',
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        } else {
            ValidatorService::validate($request, [
                'caption' => 'nullable|max:500',
                'body' => $this->mediaValidateRule->file($request->type),
                'extension' => $this->mediaValidateRule->extension($request->type),
                'filename' => 'required'
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        }
        try {
            $data = (object) $request->all();
            $isMedia = !in_array($data->type, ['poll', 'text', 'article']);
            function store ($user, $uri, $extension) {
                $file = new PostFile($user, $uri, $extension);
                return $file->store();
            }
            if ($isMedia) {
                if ($data->type === 'image') {
                    $imageResize = new ImageResize($data->body);
                    $data->body = store(
                        $request->user,
                        $imageResize->post(),
                        $data->extension
                    );
                    $data->photo_original = store(
                        $request->user,
                        $imageResize->compress(),
                        $data->extension
                    );
                } else if ($data->type === 'album') {
                    foreach ($data->photos as $key => $photo) {
                        $imageResize = new ImageResize($photo['file']);
                        $photo['photo'] = store(
                            $request->user,
                            $imageResize->post(),
                            $photo['extension']
                        );
                        $photo['photo_original'] = store(
                            $request->user,
                            $imageResize->compress(),
                            $photo['extension']
                        );
                        $data->photos[$key] = $photo;
                    }
                } else {
                    $data->body = store(
                        $request->user,
                        $data->body,
                        $data->extension
                    );
                }
            }
            if ($data->type === 'article' && $data->cover) {
                $imageResize = new ImageResize($data->cover);
                $data->cover = store(
                    $request->user,
                    $imageResize->post(),
                    $data->extension
                );
                $data->cover_original = store(
                    $request->user,
                    $imageResize->compress(),
                    $data->extension
                );
            }
            $post = $this->postRepository->create($request->user, $data);
            $openGraph = new OpenGraph($post->caption);
            $linkPreview = $openGraph->fetch();
            if ($linkPreview) {
                $post = $this->postRepository
                    ->createLinkPreview($post, $linkPreview);
            }
            ACM::post($post);
            event(new PostCreated($post));
            NotificationService::postCreate($post);
            $postMentions = $this->postMentionRepository->create($post);
            $postMentions->each(function($postMention) {
                NotificationService::postMention($postMention);
            });
            $this->postHashtagRepository->create($post);
            return ResponseService::created($post);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to create post');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $this->postRepository->delete($request->user, $id);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to delete post');
        }
        return ResponseService::ok(['isDeleted' => true]);
    }

    public function read(Request $request, $id)
    {
        try {
            $post = $this->postRepository->read($id);
        } catch (Throwable $e) {
            $message = 'Sorry, this post has been removed';
            return ResponseService::notFound($message);
        }
        return ResponseService::ok($post);
    }

    public function top()
    {
        try {
            $posts = $this->postRepository->top();
            return ResponseService::ok($posts);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect posts');
        }
    }
}
