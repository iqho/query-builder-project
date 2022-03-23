<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = DB::table('categories')->orderBy('id', 'ASC')->get(['id', 'name', 'is_active']);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
            'is_active' => 'boolean'
        ]);

        DB::table('categories')->insert([
            'name' => $request->name,
            'is_active' => $request->is_active ? $request->is_active : 0,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Created Successfully.');;
    }

    public function edit($id)
    {
        $category = DB::table('categories')->find($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $id,
            'is_active' => 'boolean'
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'is_active' => $request->is_active ? $request->is_active : 0,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully.');
    }

    public function destroy($id)
    {

        $products = DB::table('products')->where('category_id', $id)->count();

        if ($products > 0) {
            DB::table('products')->where('category_id', $id)->update(['category_id' => 1]);
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully.');
    }

    public function ChangeStatus(Request $request)
    {
        DB::table('categories')->where('id', $request->category_id)->update([
            'is_active' => $request->status
        ]);

        return response()->json(['success' => 'Category Active Status Change Successfully.']);
    }
}
