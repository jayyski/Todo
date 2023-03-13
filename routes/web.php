<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;

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

Route::get('/', function () {
    $tasks = Tasks::all();
    return view('tasks', ['tasks' => $tasks]);
});

Route::post('/create_task', function (Request $request) {

    $validated = $request->validate([
        'task' => 'required'
    ]);
    
    Tasks::create([
        'description' => $validated["task"],
    ]);

    return redirect('/');
});

Route::get('/delete/{id}', function (Tasks $id) {
    //Delete the task from the database
    $id->delete();

    return redirect('/');
});

Route::get('/delete', function () {
    $tasks = Tasks::onlyTrashed()->get();
    return view('deleted_tasks', ['tasks' => $tasks]);
});

Route::get('/confirm/delete/{id}', function ($id) {
    Tasks::onlyTrashed()->where('id', $id)->forceDelete();
    return redirect('/delete');
});
