<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\item;
use App\Models\purchase;
use App\Models\purchaseDetails;
use App\Models\vendor;
use Illuminate\Http\Request;
use PDF;
use Yajra\DataTables\DataTables;
use App\Models\account;
use App\Models\accountInfo;
use Illuminate\Support\Facades\Auth;
class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchase.index');
    }

    public function Loadall()
    {

        $purchase = purchase::where('cancel', 0)
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        return Datatables::of($purchase)
            ->addIndexColumn()
            ->addColumn('vendor', function (purchase $purchase) {
                return $purchase->VendorName->name;
            })
            ->addColumn('payment', function (purchase $purchase) {
                return $purchase->paidinfo()->sum('amount');
            })

            ->addColumn('due', function (purchase $purchase) {
                $netttoal = $purchase->nettotal;
                $payment = $purchase->paidinfo()->sum('amount');
                $due = $netttoal - $payment;
                return $due;

            })
            ->addColumn('user', function (purchase $purchase) {
                return $purchase->username ? $purchase->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($purchase) {

                $button = ' <div class="dropdown">';
                $button .= ' <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>';
                $button .= '</div>';
                $button .= '<div class="dropdown-menu dropdown-menu-end">';
                $button .= '<a href="'.route('purchase.show',$purchase->id).'" class="dropdown-item" >View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('purchase.edit', $purchase->id) . '" class="dropdown-item">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" href="' . route('purchase.pdf', $purchase->id) . '">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $purchase->id . '">Send Mail</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a >Return</a>';
                $button .= '<div href='.route('purchasereturn.create',$purchase->id).' class="dropdown-divider">Return</div>';
                $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $purchase->id . '">Delete</a>';

                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function generateUniqueCode()
    {
        $account = new purchase();
        $transection_id = $account->pluck('id')->last();
        if (!is_null($transection_id)) {
            $invoiceNumber = ($transection_id + 1);
        } else {
            $invoiceNumber = 1;
        }
        return 'PAR-' . $invoiceNumber;
    }
    public function create()
    {
        $invoice_number = $this->generateUniqueCode();
        $items = item::all();
        $vendors = vendor::all();
        return view('purchase.create', compact('items', 'vendors', 'invoice_number'));
    }
    public function newVendor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
           /*  'address' => 'required', */
        ]);
        $vendor = new vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->save();
        return redirect()->route('purchase.create');
    }


    public function store(Request $request)
    {

        $purchase = new purchase();
        $purchase->purchase_date = $request->purchase_date;
        $purchase->purchase_no = $request->purchase_no;
        $purchase->vendor_id = $request->vendor_id;
        $purchase->order_no = $request->order_no;
        $purchase->amount = $request->amount;
        $purchase->discount = $request->discount;
        $purchase->nettotal = $request->nettotal;
        $purchase->payment_id = 1;
        $purchase->status = 1;
        $purchase->user_id =  auth::id();

        if ($purchase->save()) {

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $purchaseDetails = new purchaseDetails();
                $purchaseDetails->purchase_id = $purchase->id;
                $purchaseDetails->vendor_id = $request->vendor_id;
                $purchaseDetails->item_id = $items['item_id'];
                $purchaseDetails->qty = $items['qty'];
                $purchaseDetails->sale_price = $items['sale_price'];
                $purchaseDetails->purchase_price = $items['purchase_price'];
                $purchaseDetails->amount = $items['amount'];
                $purchaseDetails->save();
            }

            $datareponse = $purchase->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function show($id)
    {
        $paymentinfos = account::where('invoice_id', $id)
            ->where('payment_type', 2)
            ->where('operation_type',2)
            ->get();
        $transectioNo = $this->TransectionNumber();
        $accountinfos = accountInfo::all();
        $purchase = purchase::find($id);

        $paymentAmount = account::where('payment_type', 2)
        ->where('operation_type', 2)
        ->where('invoice_id', $id)
        ->sum('amount');

    $nettotal = $purchase->nettotal;
    $due = $nettotal - $paymentAmount;


        return view('purchase.show', compact('purchase', 'accountinfos', 'transectioNo', 'paymentinfos','paymentAmount','due'));

    }
    public function TransectionNumber()
    {
  
        $Invoice = account::latest()
            ->first();
        if (!is_null($Invoice)) {
            $invoiceNumber = ($Invoice->invoice_no + 1);
        } else {
            $invoiceNumber = 1;
        }
        return $invoiceNumber;
    }
    public function edit($id)
    {
        $items = item::all();
        $vendors = vendor::all();
        $purchase = purchase::find($id);
        return view('purchase.edit', compact('items', 'purchase', 'vendors'));
    }

    public function Update(Request $request)
    {

        $purchase = purchase::find($request->id);
        $purchase->purchase_date = $request->purchase_date;
        $purchase->purchase_no = $request->purchase_no;
        $purchase->vendor_id = $request->vendor_id;
        $purchase->order_no = $request->order_no;
        $purchase->amount = $request->amount;
        $purchase->discount = $request->discount;
        $purchase->nettotal = $request->nettotal;
        $purchase->payment_id = 1;
        $purchase->status = 1;
        $purchase->user_id =  auth::id();

        if ($purchase->update()) {

            $invds = purchaseDetails::where('purchase_id', $purchase->id)->get();
            foreach ($invds as $inv) {
                if (!is_null($inv)) {
                    $inv->delete();
                }
            }

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $purchaseDetails = new purchaseDetails();
                $purchaseDetails->purchase_id = $purchase->id;
                $purchaseDetails->vendor_id = $request->vendor_id;
                $purchaseDetails->item_id = $items['item_id'];
                $purchaseDetails->qty = $items['qty'];
                $purchaseDetails->sale_price = $items['sale_price'];
                $purchaseDetails->purchase_price = $items['purchase_price'];
                $purchaseDetails->amount = $items['amount'];
                $purchaseDetails->save();
            }

            $datareponse = $purchase->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function purchasepdf($id)
    {
        $title="Purchase";
        $purchase = purchase::find($id);
        $pdf = PDF::loadView('pdf.purchase', compact('purchase', 'title'));
        return $pdf->stream('purchase.pdf');
    }
}