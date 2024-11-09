<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $category_repository;

    public function __construct(CategoryRepositoryInterface $category_repository)
    {
        $this->category_repository = $category_repository;
    }

    public function index()
    {
        $categories = $this->category_repository->all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $this->category_repository->create($validated_data);

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function edit($id)
    {
        $category = $this->category_repository->find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $this->category_repository->update($id, $validated_data);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $this->category_repository->delete($id);
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
