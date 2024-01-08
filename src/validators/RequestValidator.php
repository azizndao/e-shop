<?php

namespace App\validators;

abstract class RequestValidator
{
    private array $validatedData = [];
    private array $errors = [];

    public function __construct(protected array $credentials)
    {
        $this->validate();
    }

    abstract public function validate();

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function setError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    protected function setValidated(string $key, mixed $value): void
    {
        $this->validatedData[$key] = $value;
    }


    public function getValidated(): array
    {
        return $this->validatedData;
    }
}