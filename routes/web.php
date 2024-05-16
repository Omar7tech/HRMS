<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\employee\employeeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\position\positionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\trainee\traineeController;
use App\Http\Controllers\UuidController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\ModeratorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "auth"])->name("auth");

//Guest Routes
Route::middleware(['guest'])->group(function () {

    Route::redirect('/', '/login', 301);
    Route::get('/support', function () {
        return view("support", ["title" => "Support"]);
    });
    Route::fallback(function () {
        return redirect()->route("/login");
    });
});
Route::prefix('moderator')->middleware(['auth', 'can:moderator'])->group(function () {
    Route::get('/', [ModeratorController::class, 'index'])->name("moderator.index");
    Route::post('/admin/toggle-active/{id}', [ModeratorController::class, 'toggleActive'])->name('admin.toggle-active');
    Route::post('/moderator/admin/add', [ModeratorController::class, 'addAdmin'])->name("addAdmin");
    Route::delete('/admin/delete/{id}', [ModeratorController::class, 'deleteAdmin'])->name('admin.delete');
    Route::get('/admin/edit/{id}', [ModeratorController::class, 'editAdmin'])->name('admin.edit');
    Route::put('/admin/{id}', [ModeratorController::class, 'update'])->name('admin.update');

});
Route::middleware(['auth', 'can:admin', "active.admin"])->group(function () {
    Route::get('/home', [employeeController::class, "home"])->name("home");
    Route::get('/dashboard', function () {
        return view("private.dashboard")->with("title", "dashboard");
    })->name("dashboard");
    Route::resource("employee", employeeController::class);
    Route::get("Employees/statisitics", [employeeController::class, "showEmployeeStats"])->name("employees.statistics");
    Route::put("Employees/unAssignSchedule/{id}", [employeeController::class, "unAssignSchedule"])->name("employees.unassignSchedule");
    Route::post("Employees/AssignSchedule/{id}", [employeeController::class, "AssignSchedule"])->name("employees.assignSchedule");
    Route::get("Employees/terminated", [employeeController::class, "showTerminated"])->name("employees.terminated");
    Route::get("Employees/terminated/{id}", [employeeController::class, "showTerminatedEmployee"])->name("employees.show.terminated");
    Route::resource("trainee", traineeController::class);
    Route::get("hire-confirm/{id}", [traineeController::class, "confirm"])->name("onboard-confirm");
    Route::get("endtraining-confirmation/{id}", [traineeController::class, "endTrainingShow"])->name("trainee.endTraining.show");
    Route::get('/trainee/{id}/end-training-pdf', [traineeController::class, "downloadEndTrainingPdf"])->name('trainee.endTrainingPdf');
    Route::delete('/trainee/{id}/end-training', [traineeController::class, "endTraining"])->name('trainee.endTraining');
    Route::post("hire/{id}", [traineeController::class, "hire"])->name("onboard-hire");
    Route::post('/employees/restore/{id}', [EmployeeController::class, 'restore']);
    Route::resource("vacations", VacationController::class);
    Route::get('/vacation-statistics', [VacationController::class, 'statistics'])->name('vacations.statistics');
    Route::resource("positions", positionController::class);
    Route::get('/positions/{position}/employees', [PositionController::class, 'showEmployeeByPosition'])->name('positions.employees');
    Route::get("positions/{position}/delete", [positionController::class, "delete"])->name("positions.delete");
    Route::get('/search-employees', [EmployeeController::class, 'search']);
    Route::get("/trained", [traineeController::class, "trainedIndex"])->name("trained.index");
    Route::get("/trained/{id}", [traineeController::class, "showTrained"])->name("trained.show");
    Route::resource("schedules", scheduleController::class);
    Route::get("schedules/{id}/employees", [scheduleController::class, "assignedEmployees"])->name("schedule.assigned");
    Route::get("schedule/statistics", [scheduleController::class, "showStatistics"])->name("schedule.statistics");
    Route::get("uuid", [UuidController::class, "index"])->name("uuid.index");
    Route::post("uuid/check", [UuidController::class, "checkUuid"])->name("uuid.check");
    Route::post('/employee/{id}/cv/upload', [EmployeeController::class, 'uploadCv'])->name('cv.upload');
    Route::delete('/employee/{id}/cv', [EmployeeController::class, 'deleteCv'])->name('cv.delete');
    Route::post('/employee/{id}/image/upload', [EmployeeController::class, 'uploadImage'])->name('image.upload');
    Route::delete('/employee/{id}/image', [EmployeeController::class, 'deleteImage'])->name('image.delete');
    Route::view("about", "about")->name("about");
    Route::view("online-jobs", "online jobs.index")->name("online.jobs");
    Route::fallback(function () {
        return redirect()->route("home");
    });
});
Route::post('/logout', [LoginController::class, "logout"])->name("logout")->middleware("auth");


Route::prefix("error")->group(function () {
    Route::get("/500", function () {
        return view("error.500");
    })->name("500");
});
Route::prefix("error")->group(function () {
    Route::get("/admin-not-active", function () {
        return view("error.admin_notActive");
    })->name("notActive");
});

