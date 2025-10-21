<?php

namespace charlymatloc\core\application\ports\spi\exceptions;

class InvalidCredentialsException extends \Exception {
    public function __construct() {
        parent::__construct("Invalid credentials");
    }
}