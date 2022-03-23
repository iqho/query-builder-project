<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\PriceType;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{

    // try-catch                ; for any single crud or other type of action
    // DB::transaction()        ; when we use save/update in more than one table

    public function index()
    {
        $products = Product::orderBy('id', 'ASC')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->Orderby('id', 'DESC')->get(['id', 'name']);
        $price_types = PriceType::where('is_active', 1)->Orderby('id', 'ASC')->get(['id', 'name']);

        return view('products.create', compact('categories', 'price_types'));
    }

    public function store(Request $request)
    {
        // form data validation
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable',
        ]);

        try {
            // creating a product instance
            $product = new Product;

            // assigning form data to the product instance
            $product->title = $request->title;
            $product->description = $request->description;
            $product->is_active = $request->is_active ? $request->is_active : 0;
            $product->category_id = $request->category_id;

            $image = $request->file('image');
            if ($image) {
                $imageName = date("dmYhis") . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product-images'), $imageName);
                $product->image = $imageName;
            }
            $product->save();

            // Product Price Type Store
            $getAllPrices = $request->price;
            $price_type_id = $request->price_type_id;
            $active_date = $request->active_date;

            $values = [];

            foreach ($getAllPrices as $index => $price) {
                $values[] = [
                    'product_id' => $product->id,
                    'price' => $price,
                    'price_type_id' => $price_type_id[$index],
                    'active_date' => $active_date[$index],
                ];
            }

            if ( ($price !== NULL) && ($price_type_id[$index] !== NULL) ){
                $product->productPrices()->insert($values);
            }

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) {
                return redirect()->back()->withErrors(['msg' => 'This product name already exits under selected category']);
            } else {
                return redirect()->back()->withErrors(['msg' => 'Unable to process request.Error:' . json_encode($e->getMessage(), true)]);
            }

        }

        return redirect()->route('products.index')->with('success', 'Product Created Successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', 1)->Orderby('id', 'DESC')->get(['id', 'name']);
        $price_types = PriceType::where('is_active', 1)->Orderby('id', 'ASC')->get(['id', 'name']);

        return view('products.edit', compact('product', 'categories', 'price_types'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable',
        ]);

        try {
            $product->title = $request->title;
            $product->description = $request->description;
            $product->is_active = $request->is_active ? $request->is_active : 0;
            $product->category_id = $request->category_id;

            $image = $request->file('image');

            if ($image) {
                $imageName = date("dmYhis") . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product-images'), $imageName);

                if ($product->image !== null) {
                    File::delete([public_path('product-images/' . $product->image)]);
                }

                $product->image = $imageName;
            }

            $product->update();

            // Product Price Type Update
            $product_price_id = $request->product_price_id;

            if($product_price_id){
                for ($i = 0; $i < count($product_price_id); $i++) {

                    $values = [
                        'product_id' => $product->id,
                        'price' => $request->price[$i],
                        'price_type_id' => $request->price_type_id[$i],
                        'active_date' => $request->active_date[$i],
                    ];

                    $check_id = ProductPrice::find($product_price_id[$i]);

                    if ($check_id) {
                        $product->productPrices()->where('id', $check_id->id)->update($values);
                    }
                }
            }

            $price_type_new_id = $request->price_type_new_id;

            if($price_type_new_id){
                for ($i = 0; $i < count($price_type_new_id); $i++) {
                    $values2 = [
                        'product_id' => $product->id,
                        'price' => $request->new_price[$i],
                        'price_type_id' => $request->price_type_new_id[$i],
                        'active_date' => $request->new_active_date[$i],
                    ];

                    if ( ($request->new_price[$i] !== NULL) && ($request->price_type_new_id[$i] !== NULL) ){
                      $product->productPrices()->insert($values2);
                    }
                }
            }


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return redirect()->back()->withErrors(['msg' => 'This product name already exits under selected category']);
            } else {
                return redirect()->back()->withErrors(['msg' => 'Unable to process request.Error:' . json_encode($e->getMessage(), true)]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        $product->productPrices()->where('product_id', $product->id)->delete();

        File::delete([public_path('product-images/' . $product->image)]);

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully.');
    }

    public function ChangeStatus(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->is_active = $request->status;
        $product->save();

        return response()->json(['success' => 'Product Active Status Change Successfully.']);
    }

    public function priceListDestroy($price_id)
    {
        $price = ProductPrice::find($price_id);
        $price->delete();

        return response()->json([
            'success' => 'Product Price Deleted Successfully !'
        ]);
    }
}

