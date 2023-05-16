<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ScrapNewsService
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }
    public function handle(string $url): News|null
    {
        $image = "";
        $title = "";
        $subtitle = "";
        $date = "";
        $siteName = "";

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        try{
            $siteName = $crawler->filter('meta[property="og:site_name"]')
                ->first()
                ->attr('content');
        } catch(\Exception $e) { // I guess its InvalidArgumentException in this case
            echo $e->getMessage();
        }

        $title = $crawler->filter('h1')->each(function ($node) { return $node->text();});
        $title = (is_array($title)) ? $title[0] : $title;
        if ($title) {
            $subtitle = $crawler->filter('h2')->each(function ($node) { return $node->text();});
            $subtitle = (is_array($subtitle)) ? $subtitle[0] : $subtitle;
        }

        $images = $crawler->filter('img')->each(function ($node) {
            return $node;
        });
        foreach ($images as $img) {
            if ($img->attr('data-src')) {
                $image = $img->attr('data-src');
            } elseif ($img->attr('alt') == $title) {
                $image = $img->attr('src');
            } elseif (intval($img->attr('width')) > 600){
                $image = $img->attr('src');
            }
        }

        $dates = $crawler->filter('time')->each(function ($node) { return $node->text();});
        $date = (!empty($dates) && is_array($dates)) ? $dates[0] : '';

        $news = new News();
        $news->setImage($image);
        $news->setTitle($title);
        $news->setSubtitle($subtitle);
        $news->setUrl($url);
        $news->setDate($date);
        $news->setAuthor($siteName);
        $news->setToPublish(false);

        $this->newsRepository->save($news, true);

        return $news;
    }
}
