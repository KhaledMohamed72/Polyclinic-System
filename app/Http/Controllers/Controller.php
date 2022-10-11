<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getClinic()
    {
        return app()->make('clinic.active');
    }

    protected function storeImage($request)
    {
        $save_path = 'images/users';
        if (!file_exists(public_path($save_path))) {
            mkdir($save_path, 666, true);
        }
        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Image::make($file)->resize(300,200);
            $filename = time().str_random(10).'.'.$file->getClientOriginalExtension();
            $image->save(public_path('images/users/'.$filename));
            return $filename;
        }
    }
}
