<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return view('brands.index', compact('brands'));
    }

    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }
} 