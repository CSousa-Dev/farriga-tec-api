<?php
namespace App\Application\Account\DTOs;

use App\Application\Account\DTOs\AddressDTO;
use App\Application\Account\DTOs\DocumentDTO;

class RegisterAccountDTO
{
    public function __construct(
        public $firstName,
        public $lastName,
        public $email,
        public $plainPassword,
        public $birthDate,
        public DocumentDTO $document,
        public ?AddressDTO $addressDto = null
    ){}
    
}