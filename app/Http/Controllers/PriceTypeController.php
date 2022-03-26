<?php

namespace App\Http\Controllers;

use App\Models\PriceType;
use Illuminate\Http\Request;
use DB;

class PriceTypeController extends Controller
{
    public function index()
    {
        $priceTypes = DB::table('price_types')->orderBy('id', 'ASC')->get(['id','name', 'is_active']);

        return view('price-types.index', compact('priceTypes'));
    }

    public function create()
    {
        return view('price-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:price_types',
            'is_active' => 'boolean'
        ]);

        DB::table('price_types')->insert([
            'name' => $request->name,
            'is_active' => $request->is_active ? $request->is_active : 0
        ]);

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Created Successfully.');;
    }

    public function edit($id)
    {
        $ptype = DB::table('price_types')->find($id);

        return view('price-types.edit', compact('ptype'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:price_types,name,'.$id,
            'is_active' => 'boolean'
        ]);

        DB::table('price_types')->where('id', $id)->update([
            'name' => $request->name,
            'is_active' => $request->is_active ? $request->is_active : 0
        ]);

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Updated Successfully.');
    }

    public function destroy($id)
    {
        DB::table('price_types')->where('id', $id)->delete();

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Deleted Successfully.');
    }

    public function changeStatus(Request $request)
    {
        DB::table('price_types')->where('id', $request->id)->update([
            'is_active' => $request->status
        ]);

        return response()->json(['success' => 'Price Type Active Status Change Successfully.']);
    }
    
}
