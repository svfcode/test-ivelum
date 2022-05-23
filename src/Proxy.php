<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


class Proxy {
    private $pageUrl = 'https://news.ycombinator.com/';

    public function start() {
        $client = new Client([
            'base_uri' => $this->pageUrl
        ]);

        try {
            $response = $client->get($_SERVER['REQUEST_URI']);

            $handledBody = $this->add_tm($response->getBody()->getContents());

            echo $handledBody;

        } catch (ClientException $e) {
            header('HTTP/1.1 404 Not Found');
            echo $e->getResponse()->getBody()->getContents();
        }


    }

    public function add_tm($page) {
        $htmlDom = new \DOMDocument;
        @$htmlDom->loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new \DOMXPath($htmlDom);

        $tags = $xpath->query('//*//text()');

        foreach ($tags as $tag) {
            $tag->nodeValue = preg_replace_callback('/\b(\w{6})\b(\.\w|\/|:)?/u', function ($m) {
                if (array_key_exists(2, $m)) {
                    return $m[1] . $m[2];
                }
                return $m[1] . '™';
            }, $tag->nodeValue);
        }

        return $htmlDom->saveHTML();
    }
}