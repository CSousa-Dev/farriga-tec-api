<?php
namespace App\Domain\Account\Documents;
use App\Domain\Validations\Validable;

abstract class Document extends Validable
{
    public abstract function number(): string;
    public abstract function type(): string;
    public abstract function country(): string;
}