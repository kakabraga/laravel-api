<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->formatDocument($this->document, $this->type),
            'phone' => $this->maskPhone($this->phone),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function formatDocument(string $document, string $type): string
    {
        if ($type === 'cpf' && strlen($document) === 11) {
            return $this->maskCpf($document);
        }

        if ($type === 'cnpj' && strlen($document) === 14) {
            return $this->maskCnpj($document);
        }

        return $document;
    }


    private function maskCpf(string $cpf): string
    {
        return preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $cpf);
    }
    private function maskPhone(string $phone): string
    {
        return preg_replace('/(\d{2})\d{5}(\d{2})/', '($1) *****-$2', $phone);
    }

    private function maskCnpj(string $cnpj): string
    {
        return preg_replace('/(\d{2})\d{8}(\d{4})/', '$1********$2', $cnpj);
    }

}
