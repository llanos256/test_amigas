<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCourses extends Model
{
    use HasFactory;
    protected $table = 'test_courses';
    protected $fillable = ['c_id', 'name', 'credits'];
    public $timestamps = false;
    protected $primaryKey = 'c_id';
}
