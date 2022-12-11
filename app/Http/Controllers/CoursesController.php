<?php

namespace App\Http\Controllers;

use App\Models\TestCourses;
use App\Models\TestCoursesXStudent;
use App\Models\TestStudents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{

    public function getCoursesbyStudent($studentId)
    {
        $courses = DB::table('test_courses')
            ->join('test_courses_x_student', 'test_courses.c_id', '=', 'test_courses_x_student.c_id')
            ->join('test_students', 'test_courses_x_student.s_id', '=', 'test_students.s_id')
            ->select(DB::raw('test_courses.*'))
            ->where('test_students.s_id', '=', $studentId)
            ->get();
        return $courses;
    }

    public function enrollStudent(Request $request)
    {
        $response = $this->validateRelation($request);
        $isNull = $this->validateNull($request);
        if ($isNull != null) {
            return $isNull;
        }
        if ($response != null) {
            return $response;
        }
        $enroll = new TestCoursesXStudent();
        $enroll->c_id = $request->input('c_id');
        $enroll->s_id = $request->input('s_id');
        $enroll->save();
        $course = TestCourses::where('c_id', $enroll->c_id)->first();
        return response()->json([
            "Message" => "Student is now enrolled at " . $course->name
        ], 200);
    }

    public function retireStudent(Request $request)
    {
        $isNull = $this->validateNull($request);
        if ($isNull != null) {
            return $isNull;
        }
        $student = TestStudents::where('s_id', $request->input('s_id'))->first();
        $course = TestCourses::where('c_id', $request->input('c_id'))->first();
        $relation = TestCoursesXStudent::where('c_id', $request->input('c_id'))
        ->where('s_id',  $request->input('s_id'))
        ->first();
        $relation->delete();
        return response()->json(["Message" => "Student " . $student->first_name . " " . $student->last_name . " has been retired from " . $course->name], 200);
    }

    private function validateNull(Request $request)
    {
        if ($request->input('c_id') == null) {
            return response()->json([
                "error" => "courseId is null"
            ], 422);
        } else {
            if ($request->input('s_id') == null) {
                return response()->json([
                    "error" => "studentId is null"
                ], 422);
            }
        }
    }
    private function validateRelation(Request $request)
    {
        if ($request->input('c_id') != null && $request->input('s_id') != null) {
            $relation = TestCoursesXStudent::where('c_id', $request->input('c_id'))
                ->where('s_id',  $request->input('s_id'))
                ->first();

            if ($relation != null) {
                $course = TestCourses::where('c_id', $relation->c_id)->first();
                return response()->json([
                    "Message" => "Student was already enrolled at " . $course->name
                ], 422);
            }
        }
    }
}
