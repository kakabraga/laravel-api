<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CustomerStatus;
class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $casts = [
        'status' => CustomerStatus::class,
    ];

    protected $fillable = [
        'name',
        'email',
        'document',
        'type',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'status'
    ];

    public function toAuditArray(): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "type" => $this->type
        ];
    }
}
