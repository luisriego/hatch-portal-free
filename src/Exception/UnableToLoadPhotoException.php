<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UnableToLoadPhotoException extends FileException
{
    public static function unableToLoad(): self
    {
        return new self('Unable to load photo');
    }
}
