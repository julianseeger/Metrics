<?php

namespace Metrics\Core\Repository\Exception;

use Exception;

class UserNotFoundException extends \Exception
{
    public function __construct($message = "User not found", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
