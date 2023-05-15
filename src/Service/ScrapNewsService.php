<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ScrapNewsService
{
    public function handle(string $url): News|null
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

//        $image = $crawler->filter('div[style*="background-image:src"]')->each(function ($node) {
//            return $node->outerHtml();
//        });
//        $imagesCrawler = $crawler->selectImage('Kitten');
//        $image = $imagesCrawler->image();

// or do this all at once
//        $image = $crawler->selectImage('Kitten')->image();

//        $images = $crawler->filter('div[style*="background-image"]')->each(function ($node) {
//            return $node->text();
//        });
        $images = $crawler->filter('img')->each(function ($node) {
            return $node->attr('src');
        });
        foreach ($images as $image) {
            echo $image;
            dump($image);
        }
dd($images);
////        $images = $crawler->filter('[style^="background-image:url"]')->each(function ($node) {
//        $images = $crawler->filter('#elementor-frontend-inline-css > style^={background-image:url}')->each(function ($node) {
//            return $node->text();
//        });
////        dd($images);
//
////        $crawler->filter('style > ')->each(function ($node) {
        $title = $crawler->filter('h1')->each(function ($node) { return $node->text();});
        $subtitle = $crawler->filter('h2')->each(function ($node) { return $node->text();});

dd($image, $title[0], $subtitle[0]);
//        $content = file_get_contents($url);
//        $document = new DOMDocument();
//        $document->loadHTML($content);
//
//        $xPath = new \DOMXPath($document);
//        $domNodeListImage = $xPath->query('.//img');dd($domNodeListImage);
//        $result = $domNodeListImage[0]->textContent . PHP_EOL;
//dd($result);
//        $domNodeList = $xPath->query('.//h1');
//
//        if ($domNodeList) {
//            dd($domNodeList[0]->textContent . PHP_EOL);
//        }
//        dd('xiii');
////        foreach ($domNodeList as $element) {
////            $result = $element->textContent . PHP_EOL;
////        }
//
//        $result = $domNodeList[0]->textContent . PHP_EOL;
        return null;
    }
}
