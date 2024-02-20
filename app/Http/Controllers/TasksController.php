<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Events\TaskCreatedEvent;
use App\Jobs\TaskCreatedJob;

class TasksController extends Controller
{
    
    /**
     * @return View
     */
    public function index(): View
    {
        $tasks = Task::all();
        return view('tasks/index', compact('tasks'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('tasks/form', compact('categories'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponseAlias;
     */
    public function store(Request $request): RedirectResponseAlias
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $task = Task::create($data);
            TaskCreatedJob::dispatch($task);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Desculpe, não foi possível salvar os dados.');
        }

        return redirect()->route("tasks.index")->with('success', 'Cadastro feito com sucesso!');
    }


    /**
     * @param  \App\Models\Task  $task
     * @return View
     */
    public function show(Task $task): View
    {
        $categories = Category::all();

        $item = Task::findOrFail($task->id);

        return view("tasks.form",[
            "item" => $item,
            "categories" => $categories
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return RedirectResponseAlias;
     */
    public function update(Request $request, Task $task): RedirectResponseAlias
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $item = Task::findOrFail($task->id);
            $item->fill($data);
            $item->save();
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->withInput()->with('error', 'Desculpe, não foi possível atualizar os dados.');
        }

        return redirect()->route("tasks.index")->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * @param  \App\Models\Task  $task
     * @return RedirectResponseAlias;
     */
    public function destroy(Task $task): RedirectResponseAlias
    {
        DB::beginTransaction();

        try {
            $item = Task::findOrFail($task->id);
            $item->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Desculpe, não foi possível excluir a Tarefa.');
        }

        return redirect()->route("tasks.index")->with('success', 'Tarefa excluida com sucesso!');
    }

    /**
     * @return JsonResponse
     */
    public function api()
    {
        $tasks = Task::with('category')->get();

        return response()->json($tasks);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function apiShow(string $id)
    {
        try {
            $task = Task::with('category')->findOrFail($id);
            return response()->json($task);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Tarefa não encontrada'], 404);
        }
    }
}
