<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
    'name',
    'email',
    'phone',
    'message',
    ];

    public function formattedPhone(): string
    {
        if (empty($this->phone)) {
            return '';
        }

        try {
            return phone($this->phone)->formatInternational();
        } catch (\Throwable $e) {
            return $this->phone;
        }
    }

}
