<?php
namespace App\Domain\Account\User\Documents;

interface IDocument 
{
    public function __construct(string $number);
    public function number(): string;
    public function type(): string;
    public function country(): string;
}