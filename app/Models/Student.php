<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address',
        'gender',
        'avatar',
        'phone',
        'user_id',
        'birth_day',
        'faculty_id'
    ];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_subject','student_id','subject_id')
            ->withPivot('point');
    }

    public function isSubjectRegistered($subjectId)
    {
        return $this->subjects()->where('subject_id', $subjectId)->exists();
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_day)->age;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
