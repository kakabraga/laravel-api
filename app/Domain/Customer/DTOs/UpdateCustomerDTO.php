<?php

namespace App\Domain\Customer\DTOs;

class UpdateCustomerDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $document,
        public readonly ?string $type,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $zip_code,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            document: isset($data['document'])
            ? self::sanitizeDocument($data['document'])
            : null,
            type: $data['type'] ?? null,
            phone: isset($data['phone'])
            ? self::sanitizePhone($data['phone'])
            : null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            zip_code: isset($data['zip_code'])
            ? self::sanitizeZipCode($data['zip_code'])
            : null,
        );
    }

    private static function sanitizeDocument(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }

    private static function sanitizePhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }

    private static function sanitizeZipCode(string $zip): string
    {
        return preg_replace('/\D/', '', $zip);
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'type' => $this->type,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ], fn($value) => !is_null($value));
    }

}
