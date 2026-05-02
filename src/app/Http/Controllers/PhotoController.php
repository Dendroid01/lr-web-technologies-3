<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::getAllPhotos();
        $photoCount = Photo::getCount();

        return view('gallery', compact('photos', 'photoCount'));
    }

    public function show($id)
    {
        $photo = Photo::getPhotoByIndex((int) $id);

        if (!$photo) {
            return response()->json(['error' => 'Photo not found'], 404);
        }

        return response()->json([
            'index' => (int) $id,
            'src' => asset($photo['src']),
            'title' => $photo['title'],
            'hover_text' => $photo['hover_text'],
            'total' => Photo::getCount()
        ]);
    }
}
