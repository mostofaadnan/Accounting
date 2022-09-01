<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use App\Models\item;
use App\Models\purchase;
use App\Models\purchaseDetails;
use App\Models\purchaseReturn;
use App\Models\purchaseReturnDetails;
use App\Models\vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PurchaseReturnControl extends Controller
{
    public function index()
    {
        return view('purchasereturn.index');

    }
    public function Loadall()
    {

        $purchaseReturn = purchaseReturn::where('cancel', 0)
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        return Datatables::of($purchaseReturn)
            ->addIndexColumn()
            ->addColumn('customer', function (purchaseReturn $purchaseReturn) {
                return $purchaseReturn->VendroName->name;
            })
            ->addColumn('user', function (purchaseReturn $purchaseReturn) {
                return $purchaseReturn->username ? $purchaseReturn->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($purchaseReturn) {

                $button = ' <div class="dropdown">';
                $button .= ' <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>';
                $button .= '</div>';
                $button .= '<div class="dropdown-menu dropdown-menu-end">';
                $button .= '<a href="' . route('purchasereturn.show', $purchaseReturn->id) . '" class="dropdown-item" >View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('purchasereturn.edit', $purchaseReturn->id) . '" class="dropdown-item">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('invoice.pdf', $purchaseReturn->id) . '" class="dropdown-item" target="_blank">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="printslip" data-id="' . $purchaseReturn->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $purchaseReturn->id . '">Delete</a>';

                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function create($id)
    {
        $return_no = $this->ReturnNo();
        $accountinfos = accountInfo::all();
        $items = item::all();
        $vendors = vendor::all();
        $purchase = purchase::find($id);
        $purchasePayment = account::where('invoice_id', $id)
            ->where('operation_type', 2)
            ->where('payment_type', 3)
            ->get();
        $paymentAmount = $purchasePayment->sum('amount');
        $nettotal = $purchase->nettotal;
        $due = $paymentAmount - $nettotal;
        return view('purchasereturn.create', compact('items', 'purchase', 'vendors', 'accountinfos', 'return_no', 'paymentAmount', 'due'));

    }

    public function ReturnNo()
    {
        $account = new purchaseReturn();
        $transection_id = $account->pluck('id')->last();
        if (!is_null($transection_id)) {
            $invoiceNumber = ($transection_id + 1);
        } else {
            $invoiceNumber = 1;
        }
        return 'PR-' . $invoiceNumber;
    }

    public function store(Request $request)
    {

        $purchase_id = $request->purchase_id;
        $date = $request->date;

        $amount = $request->return_amount;
        $return_dicount = $request->return_discount;
        $return_nettotal = $request->return_nettotal;

        $purchase = purchase::find($purchase_id);
        $return_type = $request->return_type;

        $purchaseReturn = new purchaseReturn();
        $purchaseReturn->return_date = $request->date;
        $purchaseReturn->return_no = $request->return_no;
        $purchaseReturn->vendor_id = $purchase->vendor_id;
        $purchaseReturn->purchase_id = $purchase_id;
        $purchaseReturn->amount = $request->return_amount;
        $purchaseReturn->discount = $request->return_discount;
        $purchaseReturn->nettotal = $request->return_nettotal;
        $purchaseReturn->return_type = $return_type;
        $purchaseReturn->status = 1;
        $purchaseReturn->cancel = 0;
        $$purchaseReturn->user_id= auth::id();
        $purchaseReturn->purchase_trn_no = 0;
        if ($purchaseReturn->save()) {

            $returntableData = $request->return_itemtables;
            foreach ($returntableData as $items) {
                $retundDetails = new purchaseReturnDetails();
                $retundDetails->return_id = $purchaseReturn->id;
                $retundDetails->vendor_id = $purchase->vendor_id;
                $retundDetails->item_id = $items['item_id'];
                $retundDetails->qty = $items['qty'];
                $retundDetails->sale_price = $items['sale_price'];
                $retundDetails->purchase_price = $items['purchase_price'];
                $retundDetails->amount = $items['amount'];
                $retundDetails->save();
            }

            if ($return_type == 1) {
                //Adjustment
                $newinvno = $this->AdjustmentInvoice($request, $purchase->vendor_id, $amount);
                $purchaseReturn->purchase_trn_no = $newinvno;
                $purchaseReturn->update();

            } else {
                //Payment;
                $trnno = $this->ReturnCash($request, $amount, $purchaseReturn->id);
                $purchaseReturn->purchase_trn_no = $trnno;
                $purchaseReturn->update();
            }

            //update Invoice
            $purchaseAmount = $purchase->amount;
            $invoiceDiscount = $purchase->dicount;
            $invoiceNettotal = $purchase->nettotal;
            $remainNettotal = $invoiceNettotal - $amount;
        /*     if ($remainNettotal == 0) {
                $purchase->delete();
            } else {
                $purchase->amount = $purchaseAmount - $amount;
                $purchase->discount = $invoiceDiscount - $return_dicount;
                $purchase->nettotal = $invoiceNettotal - $return_nettotal;

                if ($purchase->update()) {

                    foreach ($returntableData as $items) {
                        $itemid = $items['item_id'];
                        $returnqty = $items['qty'];
                        $purchaseDetails = purchaseDetails::where('item_id', $itemid)
                            ->where('purchase_id', $purchase->id)
                            ->first();

                        $detailsqty = $purchaseDetails->qty;
                        $detailssaleprice = $purchaseDetails->sale_price;
                        $remainqty = $detailsqty - $returnqty;
                        if ($remainqty == 0) {
                            $purchaseDetails->delete();

                        } else {
                            $purchaseDetails->qty = $remainqty;
                            $purchaseDetails->amount = $detailssaleprice * $remainqty;
                            $purchaseDetails->update();
                        }

                    }

                }

            } */
            //End

            $datareponse = $purchaseReturn->id;
        } else {

            $datareponse = 0;
        }
        return response()->json($datareponse);

    }

    public function AdjustmentInvoice($request, $vendorid, $returnamount)
    {
        $purchaseNo = $this->PurchaseNo();
        $nettotal = $request->nettotal;
        $due = $nettotal = $returnamount;

        $purchase = new purchase();
        $purchase->purchase_date = $request->date;
        $purchase->purchase_no = $purchaseNo;
        $purchase->vendor_id = $vendorid;
      /*   $purchase->order_no = $request->order_no; */
        $purchase->amount = $request->amount;
        $purchase->discount = $request->discount;
        $purchase->nettotal = $nettotal;
        $purchase->payment = $returnamount;
        $purchase->due = $due;
        $purchase->payment_id = 1;
        $purchase->status = 1;
        $purchase->user_id = 1;

        if ($purchase->save()) {

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $purchaseDetails = new purchaseDetails();
                $purchaseDetails->purchase_id = $purchase->id;
                $purchaseDetails->vendor_id = $vendorid;
                $purchaseDetails->item_id = $items['item_id'];
                $purchaseDetails->qty = $items['qty'];
                $purchaseDetails->sale_price = $items['sale_price'];
                $purchaseDetails->purchase_price = $items['purchase_price'];
                $purchaseDetails->amount = $items['amount'];
                $purchaseDetails->save();
            }

            //Previuce Payment get Data
            $invoicePayment = account::where('invoice_id', $request->invoice_id)
                ->where('operation_type', 1)
                ->where('payment_type', 1)
                ->get();
            $paymentAmount = $paymentAmount = account::where('payment_type', 1)
                ->where('operation_type', 1)
                ->where('invoice_id', $request->invoice_id)
                ->sum('amount');

            if ($paymentAmount > 0) {
                //Delete All Payment
                foreach ($invoicePayment as $invpayment) {
                    if (!is_null($invpayment)) {
                        $invpayment->delete();
                    }
                }
                //Previuse Payment
                $previuceinvoice = purchase::find($request->purchase_id);
                $previouceNettotal = $previuceinvoice->nettotal;
                $remainNettotal = $previouceNettotal - $returnamount;

                if ($remainNettotal >= $paymentAmount) {
                    //remain due
                    $this->PurchasePayment($request, $paymentAmount, $request->purchase_id);

                } else {

                    $remainpayment = $paymentAmount - $remainNettotal;
                    $this->PurchasePayment($request, $paymentAmount, $request->purchase_id);
                    $this->PurchasePayment($request, $remainpayment, $purchase->id);

                }

                /*  if ($remainNettotal > 0) {
            $this->InvoicePayment($request, $remainNettotal, $request->invoice_id);
            } */

            }

        }
        return $purchase->id;
    }
    public function PurchasePayment($request, $amount, $purchase_id)
    {
        $tranNo = $this->TransectionNo();
        $account = new account();
        $account->payment_type = 2;
        $account->operation_type = 2;
        $account->transection_no = $tranNo;
        $account->account_id = 1;
        $account->date = $request->date;
        $account->description = "Invoice Payment";
        $account->payment_method = 1;
        $account->amount = $amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->invoice_id = $purchase_id;
        $account->status = 1;
        $$account->user_id= auth::id();
        $account->save();
        return $account->id;

    }
    public function PurchaseNo()
    {
        $purchase = new purchase();
        $transection_id = $purchase->pluck('id')->last();
        if (!is_null($transection_id)) {
            $invoiceNumber = ($transection_id + 1);
        } else {
            $invoiceNumber = 1;
        }
        return 'PAR-' . $invoiceNumber;
    }
    public function ReturnCash(Request $request, $retrunamount, $retrunid)
    {

        $invoicePayment = account::where('invoice_id', $request->purchase_id)
            ->where('operation_type', 2)
            ->where('payment_type', 2)
            ->get();
        $paymentAmount = $paymentAmount = account::where('payment_type', 2)
            ->where('operation_type', 2)
            ->where('invoice_id', $request->purchase_id)
            ->sum('amount');

        $previuceinvoice = purchase::find($request->purchase_id);
        $previouceNettotal = $previuceinvoice->nettotal();
        $remainNettotal = $previouceNettotal - $retrunamount;

        if ($remainNettotal >= $paymentAmount) {
            //remain due
            //    $this->InvoicePayment($request, $paymentAmount, $request->invoice_id);

        } else {

            $remainpayment = $paymentAmount - $remainNettotal;
            $tranNo = $this->TransectionNo();
            $account = new account();
            $account->payment_type = 1;
            $account->operation_type = 6;
            $account->transection_no = $tranNo;
            $account->account_id = $request->account_id;
            $account->date = $request->date;
            $account->description = "Retrurn Cash";
            $account->payment_method = $request->payment_method;
            $account->amount = $remainpayment;
            $account->payment_descripiton = $request->payment_descripiton;
            $account->invoice_id = $retrunid;
            $account->status = 1;
            $$account->user_id= auth::id();
            $account->save();
            return $account->id;

        }

    }

    public function TransectionNo()
    {
        $account = new account();
        $transection_id = $account->pluck('id')->last();
        if (!is_null($transection_id)) {
            $invoiceNumber = ($transection_id + 1);
        } else {
            $invoiceNumber = 1;
        }
        return 'TRN-' . $invoiceNumber;
    }
    public function show($id)
    {
        $purchasereturn = purchaseReturn::find($id);
        return view('purchasereturn.show', compact('purchasereturn'));
    }

    public function edit($id)
    {
        $return_no = $this->TransectionNumber();
        $accountinfos = accountInfo::all();
        $items = item::all();
        $vendors = vendor::all();
        $invoice = purchase::find($id);
        $purchasePayment = account::where('invoice_id', $id)
            ->where('operation_type', 2)
            ->where('payment_type', 2)
            ->get();
        $paymentAmount = $purchasePayment->sum('amount');
        $nettotal = $invoice->nettotal;
        $due = $paymentAmount - $nettotal;
        return view('purchasereturn.edit', compact('items', 'invoice', 'vendors', 'accountinfos', 'return_no', 'paymentAmount', 'due'));
    }
}
