<?php

declare(strict_types=1);

namespace Phinocio\Oauth2NexusMods\Exception;

use RuntimeException;

class InvalidUserInfoException extends RuntimeException
{
    /**
     * @param string $field
     * @param string $expected
     * @param mixed $actual
     * @return void
     */
    public function __construct(string $field, string $expected, mixed $actual)
    {
        parent::__construct(sprintf(
            'Field "%s" was expected to be %s, got %s.',
            $field,
            $expected,
            get_debug_type($actual),
        ));
    }
}
