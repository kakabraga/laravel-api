<?php

namespace App\Domain\Customer\DTOs;

class CustomerFilterDTO
{
    public function __construct(
        public readonly int $perPage,
        public readonly string $order,
        public readonly string $sort,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $perPage = max(1, min((int) ($data['per_page'] ?? 10), 50));

        $sort = strtolower($data['sort'] ?? 'created_at');
        $order = strtolower($data['order'] ?? 'desc');

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $allowedSorts = ['name', 'email', 'city', 'state', 'type', 'created_at'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        return new self(
            perPage: $perPage,
            order: $order,
            sort: $sort
        );
    }
}
