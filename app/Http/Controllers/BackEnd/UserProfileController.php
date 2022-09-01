<?php

namespace App\Http\Controllers\BackEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Image;
use File;

class UserProfileController extends Controller
{
    public function Profile()
    {
        return view('user.profile');
    }

    public function ImageChange(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('file')) {
            if (File::exists(public_path('image/user/' . $user->image))) {
                File::delete(public_path('image/user/' . $user->image));
            }
            $image = $request->File('file');
            $Path = public_path('/image/user/');
            $img = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
            $Img = Image::make($image->getRealPath());
            $Img->save($Path . '/' . $img, 50);
            $user->image = $img;
        }
        $user->update();
        return response()->json($request->File('file'));
    }
}
