<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('courses', [CoursesController::class, 'getCoursesList']);
Route::get('students', [StudentsController::class, 'getstudentList']);
Route::post('createstudent', [StudentsController::class, 'createStudent']);
Route::post('enrollstudent', [CoursesController::class, 'enrollStudent']);
Route::post('retirestudent', [CoursesController::class, 'retireStudent']);
