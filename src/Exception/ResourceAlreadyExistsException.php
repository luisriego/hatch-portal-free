<?php

declare(strict_types=1);

namespace App\Exception;

final class ResourceAlreadyExistsException extends \DomainException
{
    public static function fromSlug(string $resource, string $slug): self
    {
        return new ResourceAlreadyExistsException(\sprintf('<%s> with slug <%s> already exists', $resource, $slug));
    }

    public static function fromUrl(string $resource, string $url): self
    {
        return new ResourceAlreadyExistsException(\sprintf('<%s> with URL <%s> already exists', $resource, $url));
    }
}
