<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::all();

        return view('categories/index', compact('categories'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('categories/form');
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
            Category::create($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Desculpe, não foi possível salvar os dados.');
        }

        return redirect()->route("categories.index")->with('success', 'Cadastro feito com sucesso!');
    }

    /**
     * @param  \App\Models\Category  $category
     * @return View
     */
    public function show(Category $category): View
    {
        $item = Category::findOrFail($category->id);

        return view("categories.form",[
            "item" => $item
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return RedirectResponseAlias;
     */
    public function update(Request $request, Category $category): RedirectResponseAlias
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $item = Category::findOrFail($category->id);
            $item->fill($data);
            $item->save();
            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->withInput()->with('error', 'Desculpe, não foi possível atualizar os dados.');
        }

        return redirect()->route("categories.index")->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * @param  \App\Models\Category  $category
     * @return RedirectResponseAlias;
     */
    public function destroy(Category $category): RedirectResponseAlias
    {
        DB::beginTransaction();
        $data = ['category_id' => null];
        
        try {
            $tasks = Task::where('category_id', $category->id)->get();
            if ($tasks->isNotEmpty()) {
                $affectedRows = Task::where('category_id', $category->id)->update($data);
            }

            $item = Category::findOrFail($category->id);
            $item->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Desculpe, não foi possível excluir a Categoria.');
        }

        return redirect()->route("categories.index")->with('success', 'Categoria excluida com sucesso!');
    }

}
