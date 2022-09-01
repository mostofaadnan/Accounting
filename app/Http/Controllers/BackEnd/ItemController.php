<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\item;
use DataTables;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        return view('item.index');
    }
    public function LoadAll(Request $request)
    {
        $item = item::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($item)
            ->addIndexColumn()
            ->addColumn('name', function ($item) {
               
                return $item->CategoryName->name.' '.$item->name;
            })

            ->addColumn('action', function ($item) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('item.edit', $item->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $item->id . '"><i class="bx bxs-trash"></i></button>';
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
        $Categories=category::all();
        return view('item.create',compact('Categories'));
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
            'category_id' => 'required',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'opening_stock' => 'required|numeric',
        ]);
        $item = new item();
        $item->category_id=$request->category_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->sale = $request->sale;
        $item->purchase = $request->purchase;
        $item->type = $request->type;
        $item->purchase_price = $request->purchase_price;
        $item->sale_price = $request->sale_price;
        $item->opening_stock = $request->opening_stock;
        $item->unit = 'Kg';
        if ($item->save()) {
            Session()->flash('success', 'New Save successfully');

        } else {
            Session()->flash('erors', 'Fail To save New Item');
        }
        return redirect()->route('items');
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
        $item = item::find($id);
        return view('item.edit', compact('item'));
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
            'category_id' => 'required',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'opening_stock' => 'required|numeric',
        ]);
        $item = item::find($id);
        $item->category_id=$request->category_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->sale = $request->sale;
        $item->purchase = $request->purchase;
        $item->type = $request->type;
        $item->purchase_price = $request->purchase_price;
        $item->sale_price = $request->sale_price;
        $item->opening_stock = $request->opening_stock;
        $item->unit = 'Kg';
        if ($item->update()) {
            Session()->flash('success', 'Item Update successfully');

        } else {
            Session()->flash('erors', 'Fail To Update Data');
        }
        return redirect()->route('items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = item::find($id);
        if (!is_null($item)) {
            $item->delete();
        }
        return response()->json($item);
    }
    public function getList(){
        $item=item::all();
        return response()->json($item);
    }
}
