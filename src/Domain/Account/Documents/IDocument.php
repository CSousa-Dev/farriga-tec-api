<?php
namespace App\Domain\Account\User\Documents;
use App\Domain\Validations\IValidable;

interface IDocument extends IValidable
{
    public function __construct(string $number);
    public function number(): string;
    public function type(): string;
    public function country(): string;
}