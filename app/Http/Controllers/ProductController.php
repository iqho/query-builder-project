<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreProductRequest;
use DB;

class ProductController extends Controller
{

    public function index()
        {
            $products = DB::table('products as p')
                                ->join('categories as cat', 'p.category_id', '=', 'cat.id')
                                ->join('product_prices as p_price', function ($join) {
                                    $join->on('p.id', '=', 'p_price.product_id');
                                         //->where('p_price.product_id', '=', '5');
                                })
                                ->select('p.*', 'cat.name as cat_name', 'p_price.price as prices', 'p_price.active_date as active_dates')
                                //->groupBy('p.id')

                                ->distinct()
                                ->get();

            return view('products.index', compact('products'));
        }

    public function create()
        {
            $categories = DB::table('categories')
                                ->where('is_active', 1)
                                ->Orderby('id', 'DESC')
                                ->get(['id', 'name']);
                                
            $price_types = DB::table('price_types')
                                ->where('is_active', 1)
                                ->Orderby('id', 'ASC')
                                ->get(['id', 'name']);

            return view('products.create', compact('categories', 'price_types'));
        }

    public function store(StoreProductRequest $request)
        {
            try {
                DB::transaction(function () use($request) {

                    $imageName = NULL;

                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        $imageName = date("dmYhis") . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('product-images'), $imageName);
                    }

                    $values = [
                        'title' => $request->title,
                        'description' => $request->description,
                        'category_id' => $request->category_id,
                        'image' => $imageName,
                        'is_active' => $request->is_active ? $request->is_active : 0,
                    ];

                    DB::table('products')->insert($values);
                    $lastId = DB::getPdo()->lastInsertId();

                    // Product Price Type Store
                    $getAllPrices = $request->price;
                    $price_type_id = $request->price_type_id;
                    $active_date = $request->active_date;

                    $values = [];

                    foreach ($getAllPrices as $index => $price) {
                        $values[] = [
                            'product_id' => $lastId,
                            'price' => $price,
                            'price_type_id' => $price_type_id[$index],
                            'active_date' => $active_date[$index],
                        ];
                    }

                    if (($price !== NULL) && ($price_type_id[$index] !== NULL)) {
                        DB::table('product_prices')->insert($values);
                    }
                });

            } catch (QueryException $e) {

                return back()->withErrors(['errors' => $e->getMessage()]);

                // $errorCode = $e->errorInfo[1];
                // if ($errorCode == 1062) {
                //     return redirect()->back()->withErrors(['msg' => 'This product name already exits under selected category']);
                // } else {
                //     return redirect()->back()->withErrors(['msg' => 'Unable to process request.Error:' . json_encode($e->getMessage(), true)]);
                // }
            }

            return redirect()->route('products.index')->with('success', 'Product Created Successfully.');
        }

    public function edit($id)
        {
            $prices = DB::table('product_prices as pp')
                                    ->join('price_types as pt', 'pt.id', 'pp.price_type_id' )
                                    ->select('pp.*', 'pt.id as pt_id')
                                    ->where('product_id', $id)
                                    ->get();

            $product = DB::table('products as p')
                                    ->join('categories as cat', 'p.category_id', '=', 'cat.id')
                                    ->select('p.*', 'cat.name as cat_name', 'cat.name as cat_id')
                                    ->where('p.id', '=', $id)->first();

            $categories = DB::table('categories')
                                    ->where('is_active', 1)
                                    ->Orderby('id', 'DESC')
                                    ->get(['id', 'name']);

            $price_types = DB::table('price_types')
                                    ->where('is_active', 1)
                                    ->Orderby('id', 'ASC')
                                    ->get(['id', 'name']);

            return view('products.edit', compact('product', 'categories', 'price_types', 'prices'));
        }

    public function update(StoreProductRequest $request, $id)
        {
            try {
                DB::transaction(function () use($request, $id) {
                    $query = DB::table('products')->where('id', '=', $id);
                    $dbImage = $query->first();

                    $newImage = $request->file('image');

                    if ($newImage) {
                        $imageName = date("dmYhis") . '.' . $newImage->getClientOriginalExtension();
                        $newImage->move(public_path('product-images'), $imageName);

                        if ($dbImage->image !== null) {
                            File::delete([public_path('product-images/' . $dbImage->image)]);
                        }
                    } else {
                        $imageName = $dbImage->image;
                    }

                    $values = [
                        'title' => $request->title,
                        'description' => $request->description,
                        'category_id' => $request->category_id,
                        'image' => $imageName,
                        'is_active' => $request->is_active ? $request->is_active : 0,
                    ];

                    $query->update($values);

                    // Product Price Type Update
                    $product_price_id = $request->product_price_id;

                    if ($product_price_id) {
                        for ($i = 0; $i < count($product_price_id); $i++) {

                            $values = [
                                'product_id' => $id,
                                'price' => $request->price[$i],
                                'price_type_id' => $request->price_type_id[$i],
                                'active_date' => $request->active_date[$i],
                            ];

                            $check_id = DB::table('product_prices')->find($product_price_id[$i]);

                            if ($check_id) {
                                DB::table('product_prices')->where('id', $check_id->id)->update($values);
                            }
                        }
                    }

                    $price_type_new_id = $request->price_type_new_id;

                    if ($price_type_new_id) {
                        for ($i = 0; $i < count($price_type_new_id); $i++) {
                            $values2 = [
                                'product_id' => $id,
                                'price' => $request->new_price[$i],
                                'price_type_id' => $request->price_type_new_id[$i],
                                'active_date' => $request->new_active_date[$i],
                            ];

                            if (($request->new_price[$i] !== NULL) && ($request->price_type_new_id[$i] !== NULL)) {
                                DB::table('product_prices')->insert($values2);
                            }
                        }
                    }
                });

            } catch (QueryException $e) {
                return back()->withErrors(['errors' => $e->getMessage()]);
            }

            return redirect()->route('products.index')->with('success', 'Product Updated Successfully.');
        }

    public function destroy($id)
        {
            $query = DB::table('products')->where('id', '=', $id);
            $image = $query->first();
            $query->delete();

            DB::table('product_prices')->where('product_id', $id)->delete();

            File::delete([public_path('product-images/' . $image->image)]);

            return redirect()->route('products.index')->with('success', 'Product Deleted Successfully.');
        }

    public function updateStatus(Request $request)
        {
            DB::table('products')->where('id', $request->product_id)->update([
                'is_active' => $request->status
            ]);

            return response()->json(['success' => 'Product Active Status Change Successfully.']);
        }

    public function priceListDestroy($price_id)
        {
            $price = DB::table('product_prices')->where('id', '=', $price_id);
            $price->delete();

            return response()->json([
                'success' => 'Product Price Deleted Successfully !'
            ]);
        }

}
