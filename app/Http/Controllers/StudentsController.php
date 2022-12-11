<?php

namespace App\Http\Controllers;

use App\Models\TestStudents;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function getstudentList()
    {
        $studentList = TestStudents::all();
        return response($studentList, 200);
    }

    public function createStudent(Request $request)
    {
        $student = new TestStudents();
        if ($request->input('first_name') == null) {
            return response()->json(['first_name' => 'first_name field is null'], 422);
        }

        if ($request->input('last_name') == null) {
            return response()->json(['last_name' => 'last_name field is null'], 422);
        }

        if ($request->input('lv_id') == null) {
            return response()->json(['lv_id' => 'lv_id field is null'], 422);
        }

        if ($request->input('group') == null) {
            return response()->json(['group' => 'group field is null'], 422);
        }

        if ($request->input('email') == null) {
            return response()->json(['email' => 'email field is null'], 422);
        }
        if ($request->input('s_id') != null) {
            $student = TestStudents::where('s_id', $request->input('s_id'))->first();
        }
        $response = $this->validateType($request);
        if ($response != null) {
            return $response;
        }

        $student->first_name = $request->input('first_name');
        $student->last_name = $request->input('last_name');
        $student->lv_id = $request->input('lv_id');
        $student->group = $request->input('group');
        $student->email = $request->input('email');
        $student->phone_number = $request->input('phone_number');
        $student->geolocation = $request->input('geolocation');
        $student->status = $request->input('status');
        $student->save();
        return response()->json([
            "Message" => "Student saved",
            "Load" => $student
        ], 200);
    }

    private function validateType(Request $request)
    {
        if (!is_string($request->input('first_name')) && $request->input('first_name') != null) {
            return response()->json(['error' => "first_name must be a string"], 422);
        }

        if (!is_string($request->input('last_name')) && $request->input('last_name') != null) {
            return response()->json(['error' => "last_name must be a string"], 422);
        }

        if (!is_int($request->input('lv_id')) && $request->input('lv_id') != null) {
            return response()->json(['error' => "lv_id must be an integer"], 422);
        }
        if (!is_string($request->input('group')) && $request->input('group') != null) {
            return response()->json(['error' => 'group must be a string'], 422);
        }
        if (!is_string($request->input('email')) && $request->input('email') != null) {
            return response()->json(['error' => 'email must be a string'], 422);
        }
        if (!is_string($request->input("phone_number")) && $request->input("phone_number") != null) {
            return response()->json(['error' => 'phone_number must be a string'], 422);
        }

        if (!is_string($request->input("geolocation")) && $request->input("geolocation") != null) {
            return response()->json(['error' => 'geolocation must be a string'], 422);
        }

        if (!is_int($request->input("status"))  && $request->input("status") != null) {
            return response()->json(['error' => "status must be an integer"], 422);
        } else {
            if ($request->input("status") != 0 && $request->input("status") != 1) {
                return response()->json(['error' => "status must be 0 or 1"], 422);
            }
        }
    }
}
