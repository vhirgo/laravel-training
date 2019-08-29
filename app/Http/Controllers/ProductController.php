<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = (new Product)->newQuery();
        $product->whereNotNull('published_at');

        if ($request->search) {
            $product->orWhere('name', 'LIKE', "%{$request->search}%");
            $product->orWhere('description', 'LIKE', "%{$request->search}%");
        }

        if ($request->sort_by) {
            $product->orderBy($request->sort_by);
        }

        if ($request->sort_by_desc) {
            $product->orderByDesc($request->sort_by);
        }

        return Product::paginate($request->get('limit', 15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();
        $data['published_at'] = $request->publish ? now() : null;

        $response['message'] = "New product has been created.";
        $product = Product::create($data);

        if (request()->file('images')) {
            $imageList = [];
            foreach (request()->file('images') as $key => $image) {
                $filename = $image->storePublicly('product_images');
                $imageList[$key] = $filename;
            }

            $product->fill(['images' => $imageList]);
            $product->save();
        }

        $response['data'] = $product;

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response([
                'message' => "Fail to get product with ID {$id}, because it was not found.",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = $request->all();
        $data['published_at'] = $request->publish ? now() : null;

        $response['message'] = "Product with ID {$product->id} has been updated.";
        $response['data'] = tap($product)->update($data);

        if (request()->file('images')) {
            $imageList = [];
            foreach (request()->file('images') as $key => $image) {
                $filename = $image->storePublicly('product_images');
                $imageList[$key] = $filename;
            }

            $product->fill(['images' => $imageList]);
            $product->save();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $response['message'] = "Product with ID {$id} has been deleted.";
            $response['data'] = tap($product)->delete();
            return $response;
        } catch (ModelNotFoundException $exception) {
            return response([
                'message' => "Fail to delete product with ID {$id}, because it was not found.",
            ], 404);
        }
    }
}
