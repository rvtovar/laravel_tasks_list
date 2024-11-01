<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;

//class Task
//{
//    public function __construct(
//        public int $id,
//        public string $title,
//        public string $description,
//        public ?string $long_description,
//        public bool $completed,
//        public string $created_at,
//        public string $updated_at
//    ) {
//    }
//}
//$tasks = [
//    new Task(
//        1,
//        'Buy groceries',
//        'Task 1 description',
//        'Task 1 long description',
//        false,
//        '2023-03-01 12:00:00',
//        '2023-03-01 12:00:00'
//    ),
//    new Task(
//        2,
//        'Sell old stuff',
//        'Task 2 description',
//        null,
//        false,
//        '2023-03-02 12:00:00',
//        '2023-03-02 12:00:00'
//    ),
//    new Task(
//        3,
//        'Learn programming',
//        'Task 3 description',
//        'Task 3 long description',
//        true,
//        '2023-03-03 12:00:00',
//        '2023-03-03 12:00:00'
//    ),
//    new Task(
//        4,
//        'Take dogs for a walk',
//        'Task 4 description',
//        null,
//        false,
//        '2023-03-04 12:00:00',
//        '2023-03-04 12:00:00'
//    ),
//];

Route::get('/', function () {
    return redirect()->route('tasks.index');
});


Route::get('/tasks', function () {
    return view('index',[
        'tasks' => \App\Models\Task::latest()->paginate(10)
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');
Route::get('/tasks/{task}', function(Task $task) {;
//    $task = collect($tasks)->firstWhere('id', $id);
//    if(!$task) {
//        abort(Response::HTTP_NOT_FOUND);
//    }
//    $task = \App\Models\Task::findOrFail($id);

    return view('show', [
        'task' => $task
    ]);
})->name('tasks.show');

Route::get('/tasks/{task}/edit', function(Task $task) {

    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');




Route::Post('/tasks', function(TaskRequest $request){

//   $data = $request->validated();

//   $task = new Task;
//   $task->title = $data['title'];
//   $task->description = $data['description'];
//   $task->long_description = $data['long_description'];
//   $task->save();
   $task = Task::create($request->validated());

   return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task created successfully');
})->name('tasks.store');

Route::Put('/tasks/{task}', function(Task $task, TaskRequest $request){

    $data = $request->validated();
    $task->update($data);
////    $task = Task::findOrFail($id);
//    $task->title = $data['title'];
//    $task->description = $data['description'];
//    $task->long_description = $data['long_description'];
//    $task->save();

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task updated successfully');
})->name('tasks.update');


Route::delete('/tasks/{task}', function(Task $task){
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
})->name('tasks.destroy');


Route::patch('tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleCompleted();

    return redirect()->back()->with('success', 'Task status updated successfully');
})->name('tasks.toggle-complete');
