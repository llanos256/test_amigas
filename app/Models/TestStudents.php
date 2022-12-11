<?php

namespace App\Models;

use App\Http\Controllers\CoursesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStudents extends Model
{
    use HasFactory;
    protected $table = 'test_students';
    protected $fillable = ['s_id', 'first_name', 'last_name', 'lv_id', 'group', 'email', 'phone_number', 'geolocation', 'status'];
    public $timestamps = false;
    protected $primaryKey = 's_id';
    protected $appends = ['courses'];
    
    function getCoursesAttribute(){
        $controller = new CoursesController();
        $courseList = $controller->getCoursesbyStudent($this->s_id);
        return $courseList;
    }
}
