<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $table = 'student_subject';
    // Các trường trong bảng student_subject (nếu có)
    protected $fillable = ['student_id', 'subject_id', 'point'];
}
