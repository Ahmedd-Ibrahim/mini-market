<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index( Request $request)
    {
        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);
      $categories = Category::all();
        return view('dashboard.products.index',compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('dashboard.products.create',compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $request_data = $request->all();

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

        Product::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    } // End of Store

    public function edit(Product $product)
    {
        $categories =Category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $request_data = $request->all();
        if ($request->image) {
            if ($product->image != 'default.png') {

                Storage::disk('uploads')->delete('/product_images/' . $product->image);

            }//end of if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if
        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    } // End of Update

    public function destroy(Product $product)
    {
        if(!$product){
            session()->flash('success', __('site.no_records'));
            return redirect()->route('dashboard.clients.index');
        }
        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
