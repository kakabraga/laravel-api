<?php

namespace App\Domain\Customer\DTOs;

class CustomerDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $document,
        public readonly string $type,
        public readonly string $phone,
        public readonly string $address,
        public readonly string $city,
        public readonly string $state,
        public readonly string $zip_code,
    ) {
    }
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            document: self::sanitizeDocument($data['document']),
            type: $data['type'],
            phone: self::sanitizePhone($data['phone']),
            address: $data['address'],
            city: $data['city'],
            state: $data['state'],
            zip_code: self::sanitizeZipCode($data['zip_code']),
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
}
