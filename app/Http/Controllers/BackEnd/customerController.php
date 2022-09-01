<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\customer;
use App\Models\Invoice;
use App\Models\purchase;
use DataTables;
use Illuminate\Http\Request;

class customerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }
    public function LoadAll(Request $request)
    {
        $customer = customer::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($customer)
            ->addIndexColumn()

        /*    ->addColumn('status', function (Category $Category) {
        return $Category->status == 1 ? 'Active' : 'Inactive';
        }) */

            ->addColumn('action', function ($customer) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('customer.edit', $customer->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $customer->id . '"><i class="bx bxs-trash"></i></button>';
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
        return view('customer.create');
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
        $customer = new customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        if ($customer->save()) {
            Session()->flash('success', 'New Customer Save successfully');

        } else {
            Session()->flash('erors', 'Fail To save New Customer');
        }
        return redirect()->route('customers');
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
        $customer = customer::find($id);
        return view('customer.edit', compact('customer'));
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
        $customer = customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        if ($customer->update()) {
            Session()->flash('success', 'Customer Update successfully');

        } else {
            Session()->flash('erors', 'Fail To Update Data');
        }
        return redirect()->route('customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = customer::find($id);
        if (!is_null($customer)) {
            $invoice = Invoice::where('customer_id', $id)->get();
            if ($invoice->count() > 0) {

            } else {
                $customer->delete();
            }
        }
        return response()->json($customer);
    }
}