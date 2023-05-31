<?php

declare(strict_types=1);

namespace App\Exception;

final class AuthorAlreadyExistsException extends \DomainException
{
    public static function createFromEmail(string $email): self
    {
        return new AuthorAlreadyExistsException(\sprintf('Author with email <%s> already exists', $email));
    }
}
