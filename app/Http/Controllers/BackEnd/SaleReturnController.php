<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use App\Models\customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\item;
use App\Models\retundDetails;
use App\Models\salereturn;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{
    public function index()
    {
        return view('salereturn.index');

    }
    public function Loadall()
    {

        $salereturn = salereturn::where('cancel', 0)
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        return Datatables::of($salereturn)
            ->addIndexColumn()
            ->addColumn('customer', function (salereturn $salereturn) {
                return $salereturn->CustomerName->name;
            })
            ->addColumn('user', function (salereturn $salereturn) {
                return $salereturn->username ? $salereturn->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($salereturn) {

                $button = ' <div class="dropdown">';
                $button .= ' <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>';
                $button .= '</div>';
                $button .= '<div class="dropdown-menu dropdown-menu-end">';
                $button .= '<a href="' . route('salereturn.show', $salereturn->id) . '" class="dropdown-item" >View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('salereturn.edit', $salereturn->id) . '" class="dropdown-item">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('invoice.pdf', $salereturn->id) . '" class="dropdown-item" target="_blank">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="printslip" data-id="' . $salereturn->id . '">Print</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $salereturn->id . '">Send Mail</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="datashow" data-id="' . $salereturn->id . '">Return</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="canceldata" data-id="' . $salereturn->id . '">Cancel</a>';

                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function create($id)
    {
        $return_no = $this->TransectionNumber();
        $accountinfos = accountInfo::all();
        $items = item::all();
        $customers = Customer::all();
        $invoice = Invoice::find($id);
        $invoicePayment = account::where('invoice_id', $id)
            ->where('operation_type', 1)
            ->where('payment_type', 1)
            ->get();
        $paymentAmount = $invoicePayment->sum('amount');
        $nettotal = $invoice->nettotal;
        $due = $paymentAmount - $nettotal;
        return view('salereturn.create', compact('items', 'invoice', 'customers', 'accountinfos', 'return_no', 'paymentAmount', 'due'));

    }

    public function TransectionNumber()
    {
        /*  do {
        $code = random_int(100000, 999999);
        } while (clientInvoice::where("id", "=", $code)
        ->where('client_id', $id)
        ->first());

        return $code; */

        $Invoice = salereturn::latest()
            ->first();
        if (!is_null($Invoice)) {
            $invoiceNumber = ($Invoice->invoice_no + 1);
        } else {
            $invoiceNumber = 1;
        }
        return $invoiceNumber;
    }

    public function store(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $date = $request->date;

        $amount = $request->return_amount;
        $return_dicount = $request->return_discount;
        $return_nettotal = $request->return_nettotal;

        $invoice = Invoice::find($invoice_id);
        $return_type = $request->return_type;

        $salereturn = new salereturn();
        $salereturn->return_date = $request->date;
        $salereturn->return_no = $request->return_no;
        $salereturn->customer_id = $invoice->customer_id;
        $salereturn->invoice_id = $invoice_id;
        $salereturn->amount = $request->return_amount;
        $salereturn->discount = $request->return_discount;
        $salereturn->nettotal = $request->return_nettotal;
        $salereturn->return_type = $return_type;
        $salereturn->status = 1;
        $salereturn->cancel = 0;
        $salereturn->user_id = 1;
        $salereturn->invoice_trn_no = 0;
        $salereturn->user_id= auth::id();
        if ($salereturn->save()) {

            $returntableData = $request->return_itemtables;
            foreach ($returntableData as $items) {
                $retundDetails = new retundDetails();
                $retundDetails->return_id = $salereturn->id;
                $retundDetails->customer_id = $invoice->customer_id;
                $retundDetails->item_id = $items['item_id'];
                $retundDetails->qty = $items['qty'];
                $retundDetails->sale_price = $items['sale_price'];
                $retundDetails->purchase_price = $items['purchase_price'];
                $retundDetails->amount = $items['amount'];
                $retundDetails->save();
            }

            if ($return_type == 1) {
                //Adjustment
                $newinvno = $this->AdjustmentInvoice($request, $invoice->customer_id, $amount);
                $salereturn->invoice_trn_no = $newinvno;
                $salereturn->update();

            } else {
                //Payment;
                $trnno = $this->ReturnCash($request, $amount, $salereturn->id);
                $salereturn->invoice_trn_no = $trnno;
                $salereturn->update();
            }

            //update Invoice
            $invoiceAmount = $invoice->amount;
            $invoiceDiscount = $invoice->dicount;
            $invoiceNettotal = $invoice->nettotal;
            $remainNettotal = $invoiceNettotal - $amount;
            if ($remainNettotal == 0) {

                $invoice->delete();
            } else {
                $invoice->amount = $invoiceAmount - $amount;
                $invoice->discount = $invoiceDiscount - $return_dicount;
                $invoice->nettotal = $invoiceNettotal - $return_nettotal;

                if ($invoice->update()) {


                    foreach ($returntableData as $items) {
                        $itemid = $items['item_id'];
                        $returnqty = $items['qty'];
                        $invoiceDetails = InvoiceDetails::where('item_id', $itemid)
                            ->where('invoice_id', $invoice->id)
                            ->first();

                        $detailsqty = $invoiceDetails->qty;
                        $detailssaleprice = $invoiceDetails->sale_price;
                        $remainqty = $detailsqty - $returnqty;
                        if ($remainqty == 0) {
                            $invoiceDetails->delete();

                        } else {
                            $invoiceDetails->qty = $remainqty;
                            $invoiceDetails->amount = $detailssaleprice * $remainqty;
                            $invoiceDetails->update();
                        }

                    }

                }

            }
            //End

            $datareponse = $salereturn->id;
        } else {

            $datareponse = 0;
        }
        return response()->json($datareponse);

    }

    public function AdjustmentInvoice($request, $customerid, $returnamount)
    {
        $invoiceNo = $this->InvoiceNo();
        $nettotal = $request->nettotal;
        $due = $nettotal = $returnamount;

        $invoice = new Invoice();
        $invoice->invoice_date = $request->date;
        $invoice->invoice_no = $invoiceNo;
        $invoice->customer_id = $customerid;
        $invoice->order_no = $request->order_no;
        $invoice->amount = $request->amount;
        $invoice->discount = $request->discount;
        $invoice->nettotal = $nettotal;
        $invoice->payment = $returnamount;
        $invoice->due = $due;
        $invoice->payment_id = 1;
        $invoice->status = 1;
        $invoice->user_id = 1;

        if ($invoice->save()) {

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoice->id;
                $invoiceDetails->customer_id = $customerid;
                $invoiceDetails->item_id = $items['item_id'];
                $invoiceDetails->qty = $items['qty'];
                $invoiceDetails->sale_price = $items['sale_price'];
                $invoiceDetails->purchase_price = $items['purchase_price'];
                $invoiceDetails->amount = $items['amount'];
                $invoiceDetails->save();
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
                $previuceinvoice = Invoice::find($request->invoice_id);
                $previouceNettotal = $previuceinvoice->nettotal;
                $remainNettotal = $previouceNettotal - $returnamount;

                if ($remainNettotal >= $paymentAmount) {
                    //remain due
                    $this->InvoicePayment($request, $paymentAmount, $request->invoice_id);

                } else {

                    $remainpayment = $paymentAmount - $remainNettotal;
                    $this->InvoicePayment($request, $paymentAmount, $request->invoice_id);
                    $this->InvoicePayment($request, $remainpayment, $invoice->id);

                }

                /*  if ($remainNettotal > 0) {
            $this->InvoicePayment($request, $remainNettotal, $request->invoice_id);
            } */

            }

        }
        return $invoice->id;
    }
    public function InvoicePayment($request, $amount, $invoice_id)
    {
        $tranNo = $this->TransectionNo();
        $account = new account();
        $account->payment_type = 1;
        $account->operation_type = 1;
        $account->transection_no = $tranNo;
        $account->account_id = 1;
        $account->date = $request->date;
        $account->description = "Invoice Payment";
        $account->payment_method = 1;
        $account->amount = $amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->invoice_id = $invoice_id;
        $account->status = 1;
        $account->user_id= auth::id();
        $account->save();
        return $account->id;

    }
    public function InvoiceNo()
    {
        /*  do {
        $code = random_int(100000, 999999);
        } while (clientInvoice::where("id", "=", $code)
        ->where('client_id', $id)
        ->first());

        return $code; */

        $Invoice = Invoice::latest()
            ->first();
        if (!is_null($Invoice)) {
            $invoiceNumber = ($Invoice->invoice_no + 1);
        } else {
            $invoiceNumber = 1;
        }
        return $invoiceNumber;
    }
    public function ReturnCash(Request $request, $retrunamount, $retrunid)
    {

        $invoicePayment = account::where('invoice_id', $request->invoice_id)
            ->where('operation_type', 1)
            ->where('payment_type', 1)
            ->get();
        $paymentAmount = $paymentAmount = account::where('payment_type', 1)
            ->where('operation_type', 1)
            ->where('invoice_id', $request->invoice_id)
            ->sum('amount');

        $previuceinvoice = Invoice::find($request->invoice_id);
        $previouceNettotal = $previuceinvoice->nettotal();
        $remainNettotal = $previouceNettotal - $retrunamount;

        if ($remainNettotal >= $paymentAmount) {
            //remain due
            //    $this->InvoicePayment($request, $paymentAmount, $request->invoice_id);

        } else {

            $remainpayment = $paymentAmount - $remainNettotal;
            $tranNo = $this->TransectionNo();
            $account = new account();
            $account->payment_type = 2;
            $account->operation_type = 5;
            $account->transection_no = $tranNo;
            $account->account_id = $request->account_id;
            $account->date = $request->date;
            $account->description = "Retrurn Cash";
            $account->payment_method = $request->payment_method;
            $account->amount = $remainpayment;
            $account->payment_descripiton = $request->payment_descripiton;
            $account->invoice_id = $retrunid;
            $account->status = 1;
            $account->user_id= auth::id();
            $account->save();
            return $account->id;

        }

    }

    public function TransectionNo()
    {
        /*  do {
        $code = random_int(100000, 999999);
        } while (clientInvoice::where("id", "=", $code)
        ->where('client_id', $id)
        ->first());

        return $code; */

        $Invoice = Invoice::latest()
            ->first();
        if (!is_null($Invoice)) {
            $invoiceNumber = ($Invoice->invoice_no + 1);
        } else {
            $invoiceNumber = 1;
        }
        return $invoiceNumber;
    }
    public function show($id)
    {
        $salereturn = salereturn::find($id);
        return view('salereturn.show', compact('salereturn'));
    }
    
    public function edit($id){
        $return_no = $this->TransectionNumber();
        $accountinfos = accountInfo::all();
        $items = item::all();
        $customers = Customer::all();
        $invoice = Invoice::find($id);
        $invoicePayment = account::where('invoice_id', $id)
            ->where('operation_type', 1)
            ->where('payment_type', 1)
            ->get();
        $paymentAmount = $invoicePayment->sum('amount');
        $nettotal = $invoice->nettotal;
        $due = $paymentAmount - $nettotal;
        return view('salereturn.edit', compact('items', 'invoice', 'customers', 'accountinfos', 'return_no', 'paymentAmount', 'due'));

    }

}