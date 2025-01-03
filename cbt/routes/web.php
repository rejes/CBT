<?php
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnswerController;
// use GuzzleHttp\Middleware;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('dashboard')->name('dashboard.')->group(function(){

        Route::resource('courses', CourseCOntroller::class)
        ->middleware('role:teacher');

        Route::post('/course/question/create/{course}',[CourseStudentController::class, 'create'])
        ->middleware('role:teacher')
        ->name('course.create.question');

        Route::post('/course/question/create/save/{course}',[CourseStudentController::class, 'store'])
        ->middleware('role:teacher')
        ->name('course.course_question.store');

        Route::resource('course_questions', CourseQuestionController::class)
        ->middleware('role:teacher');

        Route::post('/course/students/create/show/{course}',[CourseStudentController::class, 'index'])
        ->middleware('role:teacher')
        ->name('course.course_students.index');

        Route::post('/course/students/create/save/{course}',[CourseStudentController::class, 'create'])
        ->middleware('role:teacher')
        ->name('course.course_students.create');

        Route::post('/course/students/create/save/{course}',[CourseStudentController::class, 'store'])
        ->middleware('role:teacher')
        ->name('course.course_students.store');

        Route::post('/course/students/create/save/{course}',[LearningController::class, 'learning_finished'])
        ->middleware('role:student')
        ->name('learning.finished.course');

        Route::post('/course/students/create/save/{course}',[LearningController::class, 'learning_rapport'])
        ->middleware('role:student')
        ->name('learning.rapport.course');

        // menampilkan beberapa kelas yang di berikan oleh guru
        Route::get('/learning', [LearningController::class, 'index'])
        ->middleware('role:student')
        ->name('learning.index');

        Route::get('/learning/{course}/{question}', [LearningController::class,'learning'])
        ->middleware('role:student')
        ->name('learning.course');

        Route::post('/learning/{course}/{question}', [LearningController::class,'store'])
        ->middleware('role:student')
        ->name('learning.course.answer.store');
    });
});
require __DIR__.'/auth.php';