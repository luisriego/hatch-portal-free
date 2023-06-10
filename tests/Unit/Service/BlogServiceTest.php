<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Repository\BlogRepository;
use App\Repository\BlogRepositoryInterface;
use App\Service\BlogService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BlogServiceTest extends TestCase
{
    private MockObject|BlogRepositoryInterface $blogRepository;
    private BlogService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blogRepository = $this->getMockBuilder(BlogRepository::class)->disableOriginalConstructor()->getMock();

        $this->service = new BlogService($this->blogRepository);
    }

    public function testBlogService(): void
    {
        $response = $this->service->handle();

        self::assertNull($response);
    }
}