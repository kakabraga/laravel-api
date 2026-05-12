<?php

namespace App\Domain\Customer\DTOs;

use App\Models\User;
use App\Http\Requests\Customer\StoreCustomerRequest;
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

    // CustomerDTO.php
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'type' => $this->type,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ];
    }

    public function toCreateAuditArray(): array
    {

        return [
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type
        ];

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
