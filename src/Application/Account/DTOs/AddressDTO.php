<?php 
namespace App\Application\Account\DTOs;

class AddressDTO
{
        public function __construct(
            public readonly ?string $street,
            public readonly ?string $number,
            public readonly ?string $neighborhood,
            public readonly ?string $city,
            public readonly ?string $state,
            public readonly ?string $country,
            public readonly ?string $zipCode,
            public readonly ?string $complement = null,
            public readonly ?string $reference = null
    ){}
}