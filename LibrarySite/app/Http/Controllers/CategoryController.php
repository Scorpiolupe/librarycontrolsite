<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $validation = [
            'category_name' => 'required|string|max:255',
        ];
        $request->validate($validation);
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
        return redirect()->route('admin.manageCategories')->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori başarıyla oluşturuldu.');
    }
}
