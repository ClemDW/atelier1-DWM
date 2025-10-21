<?php

namespace charlymatloc\core\application\ports\api\serviceinterfaces;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;
use charlymatloc\core\application\ports\api\dtos\InputUserDTO;
use charlymatloc\core\application\ports\api\dtos\UserDTO;

interface AuthServiceInterface
{
    public function register(InputUserDTO $inputUserDTO) : UserDTO;
}
