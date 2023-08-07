<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'faculty_id'
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_subject','subject_id','student_id')->withPivot('point');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function studentSubject()
    {
        return $this->hasMany(StudentSubject::class);
    }

}
