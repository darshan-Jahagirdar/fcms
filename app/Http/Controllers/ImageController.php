<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Show the avatar file
     */
    public function showAvatar($file)
    {
        return response()->file(storage_path('app/avatars') . '/' . $file);
    }

    /**
     * Show the main size photo for the given user
     */
    public function showPhoto($userId, $file)
    {
        $path = storage_path('app/photos') . '/' . $userId . '/';

        if (file_exists($path . 'main/' . $file))
        {
            return response()->file($path . 'main/' . $file);
        }

        // Legacy photos (prior to 4.0.0)
        if (file_exists($path . $file))
        {
            return response()->file($path . $file);
        }

        // Return blank file
        return response('File not found', 404);
    }

    /**
     * Show the thumbnail size photo for the given user
     */
    public function showPhotoThumbnail($userId, $file)
    {
        $path = storage_path('app/photos') . '/' . $userId . '/';

        if (file_exists($path . 'thumbnail/' . $file))
        {
            return response()->file($path . 'thumbnail/' . $file);
        }

        // Legacy photos (prior to 4.0.0)
        if (file_exists($path . 'tb_' . $file))
        {
            return response()->file($path . 'tb_' . $file);
        }

        // Return blank file
        return response('File not found', 404);
    }

    /**
     * Show the full size photo for the given user
     */
    public function showPhotoFull($userId, $file)
    {
        return response()->file(storage_path('app/photos').'/'.$userId.'/full/'.$file);
    }

    /**
     * Show the video for the given user
     */
    public function showVideo($userId, $file)
    {
        return response()->file(storage_path('app/videos').'/'.$userId.'/'.$file);
    }
}
