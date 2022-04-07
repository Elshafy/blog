<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index', [
            'categories' => Category::paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store()
    {
        Category::create($this->validateCategory());

        return redirect('/');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Category $category)
    {
        $attributes = $this->validateCategory($category);



        $category->update($attributes);

        return back()->with('success', 'Category Updated!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category Deleted!');
    }

    protected function validateCategory(?Category $category = null): array
    {
        $category ??= new Category();

        return request()->validate([
            'name' => 'required',
            'slug' => ['required', Rule::unique('categories', 'slug')->ignore($category)],
        ]);
    }
}
