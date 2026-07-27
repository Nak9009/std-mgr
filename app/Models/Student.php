<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'student_id',
        'date_of_birth',
        'grade_level',
        'status',
        'photo',
        'base64',
        'blob',
    ];


    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function fullName(): string
    {
        return "{$this->first_name}{$this->last_name}";
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->photo ? Storage::disk('public')->url($this->photo) : null,
        );
    }

    protected $appends = ['photo_url'];

}
