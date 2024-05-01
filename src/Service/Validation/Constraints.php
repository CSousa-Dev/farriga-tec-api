<?php 
namespace App\Service\Validation;
use App\Domain\Validations\IConstraints;
use App\Service\Validation\SymfonyValidationConstraints;

class Constraints extends SymfonyValidationConstraints implements IConstraints
{
}