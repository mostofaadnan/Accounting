<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
class CompanyControll extends Controller
{
    public function show()
    {

        return view('company.create');
    }

    public function update(Request $request)
    {

        $request->validate([
            'company_name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
       
        if ($request->hasfile('company_logo')) {

            $file = $request->file('company_logo');
            $Path = public_path('/image/logo/');
            $mainimg = time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            $Mainimg = Image::make($file->getRealPath());
            $Mainimg->save($Path . '/' . $mainimg, 50);
        } else {
            $mainimg=config('company.company_logo');
        }

        $company_name = $request->company_name;
        $address = $request->address;
        $email = $request->email;
        $phone = $request->phone;
        $company_logo = $mainimg;

        $array = [
            'company_name' => $company_name,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            'company_logo' => $company_logo,
        ];
        $fp = fopen(base_path('config/company.php'), 'w');
        fwrite($fp, '<?php return ' . var_export($array, true) . ';');
        fclose($fp);
        Artisan::call('config:cache');
        return redirect()->route('general.show');

    }
}
