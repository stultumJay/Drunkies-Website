<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        // For now, just return a simple view or string
        return view('categories.show', ['category' => $category]);
    }
} 