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
        $filePath = '';
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
        if ($folder === 'news') {
            $filePath = 'https://res.cloudinary.com/inovacaobrasil/image/upload/w_1000,ar_16:9,c_fill,g_auto,e_sharpen/v1683423312/'.$folder.'/'.$filename;
        } else {
            $filePath = 'https://res.cloudinary.com/inovacaobrasil/image/upload/v1683423312/'.$folder.'/'.$filename;
        }

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
