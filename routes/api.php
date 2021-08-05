<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public
Route::prefix('auth')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');
});
Route::prefix('verification')->group(function() {
    Route::post('resend', 'VerificationController@resend');
    Route::post('verify', 'VerificationController@verify');
});
Route::prefix('passwords')->group(function() {
    Route::post('reset', 'PasswordController@reset');
    Route::patch('update', 'PasswordController@update');
});
Route::post('contact', 'ContactController@contact');

// Authenticated
Route::middleware('auth.api')->group(function () {
    Route::prefix('teams')->group(function() {
        Route::get('', 'TeamController@list');
        Route::get('top', 'TeamController@top');
    });
    Route::prefix('connections')->group(function() {
        Route::post('', 'ConnectionController@create');
        Route::get('{id}', 'ConnectionController@list');
        Route::post('{id}/accept', 'ConnectionController@accept');
        Route::post('{id}/ignore', 'ConnectionController@ignore');
        Route::get('{id}/mutuals', 'ConnectionController@mutuals');
        Route::post('{id}/disconnect', 'ConnectionController@disconnect');
        Route::post('{id}/cancel', 'ConnectionController@cancel');
    });
    Route::prefix('notes')->group(function() {
        Route::get('', 'NoteController@list');
        Route::get('archived', 'NoteController@archived');
        Route::post('', 'NoteController@create');
        Route::put('{id}', 'NoteController@edit');
        Route::delete('{id}/archive', 'NoteController@archive');
        Route::delete('{id}', 'NoteController@delete');
        Route::delete('blanks', 'NoteController@deleteBlanks');
        Route::post('{id}/unarchive', 'NoteController@unarchive');
    });
    Route::prefix('peoples')->group(function() {
        Route::get('mayknow', 'PeopleController@mayknow');
        Route::get('paginate/{page?}', 'PeopleController@paginate');
        Route::get('search', 'PeopleController@search');
    });
    Route::prefix('comments')->group(function() {
        Route::post('', 'CommentController@create');
        Route::delete('{id}', 'CommentController@delete');
        Route::prefix('{commentId}/votes')->group(function() {
            Route::post('', 'CommentVoteController@create');
            Route::delete('', 'CommentVoteController@delete');
        });
        Route::get('mentions/suggestions', 'CommentMentionController@suggestions');
        Route::get('mentions/suggestions/search', 'CommentMentionController@searchSuggestions');
    });
    Route::prefix('stars')->group(function() {
        Route::post('', 'StarController@create');
        Route::delete('{postId}', 'StarController@delete');
    });
    Route::prefix('favourites')->group(function() {
        Route::post('', 'FavouriteController@create');
        Route::delete('{id}', 'FavouriteController@delete');
        Route::get('paginate', 'FavouriteController@paginate');
    });
    Route::prefix('messages')->group(function() {
        Route::get('{id}', 'MessageController@read');
        Route::post('', 'MessageController@create');
        Route::get('{chatId}/paginate', 'MessageController@paginate');
        Route::get('unreads/count', 'MessageController@unreadsCount');
    });
    Route::prefix('users')->group(function() {
        Route::put('', 'UserController@edit');
        Route::post('', 'UserController@delete');
        Route::post('status', 'UserStatusController@update');
    });
    Route::prefix('chats')->group(function() {
        Route::delete('{id}/archive', 'ChatController@archive');
        Route::post('{id}/unarchive', 'ChatController@unarchive');
        Route::get('paginate/{page?}', 'ChatController@paginate');
        Route::get('archived/{page?}', 'ChatController@archived');
        Route::get('search', 'ChatController@search');
        Route::post('{id}/read', 'ChatController@read');
        Route::get('user/{id}', 'ChatController@readFromUser');
        Route::post('mark/delivered', 'ChatController@markDelivered');
    });
    Route::prefix('posts')->group(function() {
        Route::post('', 'PostController@create');
        Route::delete('{id}', 'PostController@delete');
        Route::get('{postId}/stars', 'PostStarController@paginate');
        Route::get('mentions/suggestions', 'PostMentionController@suggestions');
        Route::get('mentions/suggestions/search', 'PostMentionController@searchSuggestions');
        Route::post('{postId}/unfollows', 'PostUnfollowController@create');
        Route::delete('{postId}/unfollows', 'PostUnfollowController@delete');
    });
    Route::prefix('notifications')->group(function() {
        Route::get('{id}', 'NotificationController@read');
        Route::put('{id}/read', 'NotificationController@markRead');
        Route::post('read/all', 'NotificationController@markAllRead');
        Route::get('unreads/count', 'NotificationController@unreadsCount');
        Route::get('paginate', 'NotificationController@paginate');
        Route::get('connection-requests', 'NotificationController@connectionRequests');
    });    
    Route::prefix('unfollows')->group(function() {
        Route::post('', 'UnfollowController@create');
        Route::delete('{connectionId}', 'UnfollowController@delete');
    });
    Route::get('auth/user', 'AuthController@user');
    Route::put('sessions', 'SessionController@update');
    Route::put('settings', 'SettingsController@update');
    Route::put('passwords', 'PasswordController@change');
    Route::post('reportings', 'ReportingController@create');
    Route::post('poll/votes', 'PollVoteController@create');
});

// Public and authenticated
Route::middleware('auth.user')->group(function () {
    Route::prefix('users/{username}')->group(function() {
        Route::get('', 'UserController@read');
        Route::get('posts', 'UserController@posts');
    });
    Route::prefix('hashtags')->group(function() {
        Route::get('trending', 'HashtagController@trending');
        Route::get('{hashtag}/posts', 'HashtagController@posts');
    });
    Route::prefix('teams')->group(function() {
        Route::get('{slug}', 'TeamController@read');
        Route::get('{id}/contributors', 'TeamController@contributors');
        Route::get('{id}/posts', 'TeamController@posts');
    });
    Route::prefix('posts')->group(function() {
        Route::get('{id}', 'PostController@read');
        Route::get('top', 'PostController@top');
    });
    Route::get('search/all', 'SearchController@all');
    Route::get('comments/{postId}/paginate', 'CommentController@paginate');
});