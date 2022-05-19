<?php

namespace App;

use GuzzleHttp\Client;

class Proxy {
    private $pageUrl = 'https://news.ycombinator.com/';

    public function start() {
        $client = new Client([
            'base_uri' => $this->pageUrl
        ]);

        $response = $client->get($_SERVER['REQUEST_URI']);

        $handledBody = $this->handle_relative_path($response->getBody()->getContents());
        $handledBody = $this->add_tm($handledBody);

        echo $handledBody;
    }

    public function handle_relative_path($page) {
        $htmlDom = new \DOMDocument;
        @$htmlDom->loadHTML($page);

        $htmlDom = $this->handle_relative_path_worker($htmlDom, 'img', 'src');
        $htmlDom = $this->handle_relative_path_worker($htmlDom, 'link', 'href');
        $htmlDom = $this->handle_relative_path_worker($htmlDom, 'script', 'src');

        return $htmlDom->saveHTML();
    }

    private function handle_relative_path_worker($htmlDom, $tag, $attr) {
        $tags = $htmlDom->getElementsByTagName($tag);

        foreach ($tags as $tag){
            $src = $tag->getAttribute($attr);

            if (substr($src, 0 , 7) != 'http://' || substr($src, 0 , 8) != 'https://') {
                $tag->setAttribute($attr, $this->pageUrl . $src);
            }
        }

        return $htmlDom;
    }

    public function add_tm($page) {
        $htmlDom = new \DOMDocument;
        @$htmlDom->loadHTML($page);
        $xpath = new \DOMXPath($htmlDom);

        $tags = $xpath->query('//*//text()');

        foreach ($tags as $tag) {
            $tag->nodeValue = preg_replace_callback('/\b(\w{6})\b(\.\w|\/|:)?/', function ($m) {
                if (array_key_exists(2, $m)) {
                    return $m[1] . $m[2];
                }
                return $m[1] . '™';
            }, $tag->nodeValue);
        }

        return $htmlDom->saveHTML();
    }
}