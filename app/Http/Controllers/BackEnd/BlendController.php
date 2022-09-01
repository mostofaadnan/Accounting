<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\blend;
use App\Models\blendDetails;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class BlendController extends Controller
{

    public function index()
    {
        return view('blend.index');
    }
    public function Loadall()
    {

        $blend = blend::orderBy('id', 'DESC')
            ->latest()
            ->get();
        return Datatables::of($blend)
            ->addIndexColumn()
            ->addColumn('item', function (blend $blend) {
                return $blend->productName->CategoryName->name.' '.$blend->productName->name;
            })
          
            ->addColumn('user', function (blend $blend) {
                return $blend->username ? $blend->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($blend) {

                $button = ' <div class="dropdown">';
                $button .= ' <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>';
                $button .= '</div>';
                $button .= '<div class="dropdown-menu dropdown-menu-end">';
                $button .= '<a href="' . route('blend.show', $blend->id) . '" class="dropdown-item" >View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('blend.edit', $blend->id) . '" class="dropdown-item">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('invoice.pdf', $blend->id) . '" class="dropdown-item" target="_blank">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $blend->id . '">Delete</a>';

                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function create()
    {
        $generalitems = item::where('type', "general")->get();
        $blenditems = item::where('type', "blend")->get();
        return view('blend.create', compact('generalitems', 'blenditems'));
    }

    public function store(Request $request)
    {

        $blinds = new blend();
        $blinds->date = $request->date;
        $blinds->item_id = $request->item_id;
        $blinds->sale_price = $request->sale_price;
        $blinds->purchase_price = $request->purchase_price;
        $blinds->totalqty = $request->totalqty;
        $blinds->amount = $request->amount;
        $blinds->user_id = auth::id();
        if ($blinds->save()) {
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $blenddetails = new blendDetails();
                $blenddetails->blend_id = $blinds->id;
                $blenddetails->item_id = $items['item_id'];
                $blenddetails->qty = $items['qty'];
                $blenddetails->sale_price = $items['sale_price'];
                $blenddetails->purchase_price = $items['purchase_price'];
                $blenddetails->amount = $items['amount'];
                $blenddetails->save();
            }

            $datareponse = $blinds->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function show($id)
    {

        $blend = blend::find($id);
        return view('blend.show', compact('blend'));
    }

    public function edit($id)
    {
        $generalitems = item::where('type', "general")->get();
        $blenditems = item::where('type', "blend")->get();
        $blend = blend::find($id);
        return view('blend.edit', compact('generalitems', 'blenditems', 'blend'));
    }

    public function update(Request $request)
    {

        $blinds = blend::find($request->id);
        $blinds->date = $request->date;
        $blinds->item_id = $request->item_id;
        $blinds->sale_price = $request->sale_price;
        $blinds->purchase_price = $request->purchase_price;
        $blinds->totalqty = $request->totalqty;
        $blinds->amount = $request->amount;
        $blinds->user_id = auth::id();
        if ($blinds->save()) {
            $details = blendDetails::where('blend_id', $request->id)->get();
            foreach ($details as $detail) {
                if (!is_null($detail)) {
                    $detail->delete();
                }
            }
            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $blenddetails = new blendDetails();
                $blenddetails->blend_id = $blinds->id;
                $blenddetails->item_id = $items['item_id'];
                $blenddetails->qty = $items['qty'];
                $blenddetails->sale_price = $items['sale_price'];
                $blenddetails->purchase_price = $items['purchase_price'];
                $blenddetails->amount = $items['amount'];
                $blenddetails->save();
            }
            $datareponse = $blinds->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function destroy($id)
    {
        $blend = blend::find($id);
        if (!is_null($blend)) {
            $blend->delete();

        }
    }
}
