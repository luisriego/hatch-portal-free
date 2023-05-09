<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Exception\ApiError;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService
{
    public function __construct(
        private readonly string $cloudinaryKey,
        private readonly string $cloudinarySecret,
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(UploadedFile $file, string $folder): string
    {
        $filename = bin2hex(random_bytes(6));

        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => 'inovacaobrasil',
                    'api_key'    => $this->cloudinaryKey,
                    'api_secret' => $this->cloudinarySecret,
                ],
            ]
        );
        $filePath = 'https://res.cloudinary.com/inovacaobrasil/image/upload/v1683423312/'.$folder.'/'.$filename;

        try {
            $cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                ['public_id' => $filename, 'folder' => $folder]);
        } catch (ApiError $e) {
            echo 'An error occurred while creating your directory at '.$e;
        }

        return $filePath;
    }

}
