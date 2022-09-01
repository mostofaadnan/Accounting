<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Image;

class UserController extends Controller
{

    /*   function __construct()
    {
    $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show', 'profile']]);
    $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:user-edit', ['only' => ['edit', 'update', 'DataUpdate']]);
    $this->middleware('permission:user-delete', ['only' => ['delete']]);
    } */
    public function index()
    {
        return view('user.index');
    }
    public function create()
    {

        return view('user.create');
    }

    public function LoadAll()
    {
        $users = User::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($users) {
                return $users->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($users) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= '<button id="dataedit" type="button" name="delete" data-id="' . $users->id . '" class="delete btn btn-outline-success btn-sm">Edit</button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button id="datadelete" type="button" name="delete" data-id="' . $users->id . '" class="btn btn-outline-danger btn-sm">Delete</button>';
                $button .= '</div>';
                return $button;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
           
            /*  'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:122048', */

        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        if ($request->hasFile('user_image')) {

            $image = $request->File('user_image');
            $Path = public_path('/image/user/');
            $img = time() . rand(1, 100) . '.' . $image->getClientOriginalExtension();
            $Img = Image::make($image->getRealPath());
            $Img->save($Path . '/' . $img, 50);
            $input['image'] = $img;
        }

        User::create($input);
        return redirect()->route('users');
    }

    public function edit($id)
    {

        $user = User::find($id);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            /* 'password' => 'required|same:password_confirmation', */
            'roles' => 'required',
            /*  'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:122048', */

        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        if ($request->hasFile('user_image')) {
            if (File::exists('images/User/' . $user->image)) {
                File::delete('images/User/' . $user->image);
            }
            $image = $request->File('user_image');
            $img = time() . $image->getClientOriginalExtension();
            $location = public_path('images/User/' . $img);
            Image::make($image)->save($location);
            $input['image'] = $img;
        }
        $user->update($input);

        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }
}
