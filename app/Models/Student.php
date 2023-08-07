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
        'faculty_id',
        'total_point',
        'status'
    ];

    const STATUS_ENROLLED = 'Enrolled'; // Đang học
    const STATUS_DROPPED = 'Dropped'; // Buộc thôi học

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->withPivot('point');
    }

    public function isSubjectRegistered($subjectId)
    {
        return $this->subjects()->where('subject_id', $subjectId)->exists();
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    // optimize lại
    public function registeredSubjectsCount()
    {
        return $this->studentSubjects()->count();
    }


    public function studentSubjects()
    {
        return $this->hasMany(StudentSubject::class);
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
