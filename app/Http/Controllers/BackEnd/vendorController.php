<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\purchase;
use App\Models\vendor;
use DataTables;
use Illuminate\Http\Request;

class vendorController extends Controller
{
    public function index()
    {
        return view('vendor.index');
    }
    public function LoadAll(Request $request)
    {
        $vendor = vendor::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($vendor)
            ->addIndexColumn()

        /*    ->addColumn('status', function (Category $Category) {
        return $Category->status == 1 ? 'Active' : 'Inactive';
        }) */

            ->addColumn('action', function ($vendor) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('vendor.edit', $vendor->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $vendor->id . '"><i class="bx bxs-trash"></i></button>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);
        $vendor = new vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        if ($vendor->save()) {
            Session()->flash('success', 'New Vendor Save successfully');

        } else {
            Session()->flash('erors', 'Fail To save New Vendor');
        }
        return redirect()->route('vendors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = vendor::find($id);
        return view('vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $request->id;
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);
        $vendor = vendor::find($id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        if ($vendor->update()) {
            Session()->flash('success', 'Vendor Update successfully');

        } else {
            Session()->flash('erors', 'Fail To Update Data');
        }
        return redirect()->route('vendors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendors = vendor::find($id);
        if (!is_null($vendors)) {
            $purchase = purchase::where('supplier_id', $id)->get();
            if ($purchase->count() > 0) {

            } else {
                $vendors->delete();
            }

        }
        return response()->json($vendors);
    }
}
