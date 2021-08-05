<?php

namespace App\Services;

use Exception;
use shweshi\OpenGraph\OpenGraph as Protocol;

class OpenGraph
{
    private $protocol;
    private $content;

    function __construct($content)
    {
        $this->protocol = new Protocol;
        $this->content = $content;
    }

    private function link ()
    {
        $this->content = trim(preg_replace('/\s+/', ' ', $this->content));
        $regex = '/https?\:\/\/[^\" ]+/i';
        preg_match_all($regex, $this->content, $matches);
        return $matches[0] ? $matches[0][0] : null;
    }

    public function fetch ()
    {
        try {
            $link = $this->link();
            if (!$link) throw new Exception('No links valid links');
            $response = $this->protocol->fetch($link);
            return (object) [
                'title' => $response['title'],
                'description' => $response['description'],
                'url' => $link, // $response['url'] striping out query parts
                'image' => isset($response['image:secure_url']) ? $response['image:secure_url'] : $response['image']
            ];
        } catch (Exception $e) {
            return null;
        }
    }
}