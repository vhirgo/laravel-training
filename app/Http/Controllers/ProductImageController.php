<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $path = 'app/product_images/' . $request->image;
        $mime = mime_content_type(storage_path($path));
        $file = file_get_contents(storage_path($path));

        return response($file, 200, [
            'Content-type' => $mime,
        ]);
    }
}
