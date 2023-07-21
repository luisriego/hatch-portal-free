<?php

namespace App\Tests\Functional\Homepage;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageTest extends WebTestCase
{
    public function testHomepageBasics(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Vem aí o prêmio Local de Inovação 2023');
        $this->assertSelectorTextContains('h2', 'Últimos Posts do nosso Blog');
        $this->assertSelectorTextContains('h3', 'As inscrições se encerram em 31 de outubro de 2023.');
    }

    public function testHomepageMenu(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.nav a', 'Projetos');
    }
}
