<?php

abstract class DomainException Extends Exception
{
    public function __construct(
        private string $message,
        private int $code = 400,
        Throwable $previous = null
    )
    {
        parent::__construct($this->defaultMessage(), $this->defaultCode(), $previous);
    }

    public abstract function defaultMessage(): string;

    public abstract function defaultCode(): int;
}