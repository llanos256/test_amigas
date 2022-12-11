<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCoursesXStudent extends Model
{
    use HasFactory;
    protected $table = 'test_courses_x_student';
    protected $fillable = ['cxs_id', 'c_id', 's_id'];
    protected $primaryKey = 'cxs_id';
    public $timestamps = false;
}
