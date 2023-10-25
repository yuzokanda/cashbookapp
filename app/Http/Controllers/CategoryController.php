<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();

        return Inertia::render('Categories/CategoryIndex', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/CategoryCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $user_id = Auth::user()->id;

        Category::create([
            'user_id' => $user_id,
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('message', 'Category Created Successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('message', 'Category Delete Successfully');
    }
}
