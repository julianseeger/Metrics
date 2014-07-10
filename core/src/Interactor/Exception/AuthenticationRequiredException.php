<?php

namespace Metrics\Core\Interactor\Exception;

use Exception;

class AuthenticationRequiredException extends \Exception
{
    public function __construct($message = "Not authenticated", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
