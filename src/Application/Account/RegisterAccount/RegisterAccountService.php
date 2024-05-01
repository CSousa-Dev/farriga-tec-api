<?php
namespace App\Application\Account\RegisterAccount;

use DateTime;
use App\Domain\Account\User\User;
use App\Domain\Account\Documents\Document;
use App\Domain\Account\User\PlainTextPassword;
use App\Domain\Account\Repository\UserRepository;
use App\Application\Account\DTOs\RegisterAccountDTO;
use App\Domain\Account\Services\RegisterUser\RegisterUser;
use App\Domain\Account\User\ValidationRules\UserValidation;
use App\Application\Account\RegisterAccount\ValidateRegisterInputs;
use App\Domain\Account\Documents\ValidationRules\DocumentValidation;
use App\Domain\Account\User\ValidationRules\PlainTextPasswordValidation;

class RegisterAccountService
{
    public function __construct(
        private ValidateRegisterInputs $validateRegisterInputs,
        private UserRepository $userRepository,
        private RegisterUser $registerUser,
        private PlainTextPasswordValidation $plainTextPasswordValidation,
        private DocumentValidation $documentValidation,
        private UserValidation $userValidation
    ){}

    public function execute(RegisterAccountDTO $registerAccountDto): void
    {
        // $this->validateRegisterInputs->execute($registerAccountDto);
        // $this->registerUser->execute(
        //     new PlainTextPassword(
        //         $registerAccountDto->plainPassword,
        //         $this->plainTextPasswordValidation
        //     ), 
        //     new User(
        //         null,
        //         $registerAccountDto->firstName,
        //         $registerAccountDto->lastName,
        //         new Document(
        //             $this->documentValidation,
        //             $registerAccountDto->document->documentNumber,
        //             $registerAccountDto->document->documentType
        //         ),
        //         $this->userValidation,
        //         new DateTime($registerAccountDto->birthDate),
        //         new Email($registerAccountDto->email,
        //     )
        //     ));
    }


}