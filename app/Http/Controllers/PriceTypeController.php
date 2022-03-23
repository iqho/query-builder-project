<?php

namespace App\Http\Controllers;

use App\Models\PriceType;
use Illuminate\Http\Request;

class PriceTypeController extends Controller
{

    public function index()
    {
        $priceTypes = PriceType::orderBy('id', 'ASC')->get(['id','name', 'is_active']);

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

        $ptype = new PriceType;
        $ptype->name = $request->name;
        $ptype->is_active = $request->is_active ? $request->is_active : 0;
        $ptype->save();

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Created Successfully.');;
    }

    public function edit(PriceType $ptype)
    {
        return view('price-types.edit', compact('ptype'));
    }

    public function update(Request $request, PriceType $ptype)
    {
        $request->validate([
            'name' => 'required|max:255|unique:price_types,name,'.$ptype->id,
            'is_active' => 'boolean'
        ]);

        $ptype->name = $request->name;
        $ptype->is_active = $request->is_active ? $request->is_active : 0;
        $ptype->update();

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Updated Successfully.');
    }

    public function destroy(PriceType $ptype)
    {
        $ptype->delete();

        return redirect()->route('all.price-type')->with('success', 'Product Price Type Deleted Successfully.');
    }

    public function ChangeStatus(Request $request)
    {
        $ptype = PriceType::find($request->id);
        $ptype->is_active = $request->status;
        $ptype->save();

        return response()->json(['success' => 'Price Type Active Status Change Successfully.']);
    }
}
