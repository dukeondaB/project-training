<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'detail',
    ];

    protected $appends = ['name'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
