<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function uploadImage(UploadImageRequest $request)
    {

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $imageUrl = Storage::url($imagePath);

            return response()->json(['message' => 'Image uploaded successfully', 'image_url' => $imageUrl], 201);
        } else {
            return response()->json(['error' => 'No image file provided'], 400);
        }
    }
}
