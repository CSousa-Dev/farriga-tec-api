<?php

use App\Application\Account\DTOs\AddressDTO;
use App\Application\Account\DTOs\DocumentDTO;

class UserDTO
{
    public function __construct(
        public readonly ?string $email,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $birthDate,
        public readonly ?string $plainPassword,
        public readonly ?DocumentDTO $documentDTO,
        public readonly ?AddressDTO $addressDTO
    ){}
}