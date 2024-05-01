<?php 
namespace App\Application\Account\DTOs;

class DocumentDTO
{
    public function __construct(
        public ?string $documentNumber = null,
        public ?string $documentType = null
    ){}
}