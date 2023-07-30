<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address',
        'gender',
        'avatar',
        'user_id',
        'birth_day'
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
            ->withPivot(['student_id', 'subject_id','created_at', 'updated_at']);
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_day)->age;
    }
}
