<?php

use App\Http\Controllers\Aggregates\CreateLearnerController;
use App\Http\Controllers\Aggregates\GetNewsletters;
use App\Http\Controllers\Aggregates\LearnerDetailedInformation;
use App\Http\Controllers\Aggregates\UsageStatistics;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GradeLearnerController;
use App\Http\Controllers\LearnerInfoController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SchoolController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
|--------------------------------------------------------------------------
| Contacts API Routes
|--------------------------------------------------------------------------
*/

Route::get('/contacts/index', [ContactController::class, 'index']);
Route::get('/contacts/show/{id}', [ContactController::class, 'show']);
Route::post('/contacts/store', [ContactController::class, 'store']);
Route::patch('/contacts/update/{contact_id}', [ContactController::class, 'update']);
Route::delete('/contacts/destroy/{id}', [ContactController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Grades API Routes
|--------------------------------------------------------------------------
*/
Route::get('/grades/get', [GradeController::class, 'all_grades']);
Route::get('/grades/index', [GradeController::class, 'index']);
Route::get('/grades/show/{id}', [GradeController::class, 'show']);
Route::post('/grades/store', [GradeController::class, 'store']);
Route::patch('/grades/update/{contact_id}', [GradeController::class, 'update']);
Route::delete('/grades/destroy/{id}', [GradeController::class, 'destroy']);

Route::get('/grade_learner/index', [GradeLearnerController::class, 'index']);
Route::get('/grade_learner/show/{id}', [GradeLearnerController::class, 'show']);
Route::post('/grade_learner/store', [GradeLearnerController::class, 'store']);
Route::patch('/grade_learner/update/{contact_id}', [GradeLearnerController::class, 'update']);
Route::delete('/grade_learner/destroy/{id}', [GradeLearnerController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Learner Info API Routes
|--------------------------------------------------------------------------
*/
Route::get('/learners/index', [LearnerInfoController::class, 'index']);
Route::get('/learners/show/{id}', [LearnerInfoController::class, 'show']);
Route::post('/learners/store', [LearnerInfoController::class, 'store']);
Route::patch('/learners/update/{contact_id}', [LearnerInfoController::class, 'update']);
Route::delete('/learners/destroy/{id}', [LearnerInfoController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Newsletters API Routes
|--------------------------------------------------------------------------
*/
Route::get('/newsletters/index', [NewsletterController::class, 'index']);
Route::get('/newsletters/show/{id}', [NewsletterController::class, 'show']);
Route::post('/newsletters/store', [NewsletterController::class, 'store']);
Route::patch('/newsletters/update/{contact_id}', [NewsletterController::class, 'update']);
Route::delete('/newsletters/destroy/{id}', [NewsletterController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Schools API Routes
|--------------------------------------------------------------------------
*/
Route::get('/schools/index', [SchoolController::class, 'index']);
Route::get('/schools/show/{id}', [SchoolController::class, 'show']);
Route::post('/schools/store', [SchoolController::class, 'store']);
Route::patch('/schools/update/{contact_id}', [SchoolController::class, 'update']);
Route::delete('/schools/destroy/{id}', [SchoolController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Aggregates Routes
|--------------------------------------------------------------------------
*/
//GET Learner Information
Route::get('/query/learner-information', [LearnerDetailedInformation::class, 'learner_information']);
Route::get('/query/get_last_learner_information', [LearnerDetailedInformation::class, 'get_last_learner_information']);

//GET Newsletters
Route::get('/newsletters/get-newsletters', [GetNewsletters::class, 'get_newsletters']);

//GET Dashboard
Route::get('/query/dashboard', [UsageStatistics::class, 'get_usage_statisctics']);

//POST Create Learner
Route::post('/aggregates/learner/store', [CreateLearnerController::class, 'create_learner']);


