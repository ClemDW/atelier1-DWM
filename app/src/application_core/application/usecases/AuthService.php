<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;
use charlymatloc\core\application\ports\api\dtos\InputUserDTO;
use charlymatloc\core\application\ports\api\dtos\UserDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\core\application\ports\spi\exceptions\InvalidCredentialsException;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
use \Ramsey\Uuid\Uuid;

class AuthService implements AuthServiceInterface
{
    private AuthRepositoryInterface $authRepository;
    public function __construct(AuthRepositoryInterface $userRepository){
        $this->authRepository = $userRepository;
    }

    public function register(InputUserDTO $inputUserDTO): UserDTO
    {
        $email = $inputUserDTO->email;
        $password = $inputUserDTO->password;
        $nom = $inputUserDTO->nom;
        $prenom = $inputUserDTO->prenom;
        $id = Uuid::uuid4();
        $user = $this->authRepository->create($id, $email, $password, $nom, $prenom);
        return new UserDTO($user->getId(), $user->getEmail(), $user->getNom(), $user->getPrenom());
    }

    public function byCredentials(CredentialsDTO $credentials): UserDTO
    {
        $user = $this->authRepository->findByEmail($credentials->email);
         // Vérifier si l'utilisateur existe


        if ($user === null) {


            throw new InvalidCredentialsException();


        }


        


        if(password_verify($credentials->password, $user->getPassword())){
            return new UserDTO($user->getId(), $user->getEmail(), $user->getNom(), $user->getPrenom());
        }else{
            throw new InvalidCredentialsException();
        }
    }
}