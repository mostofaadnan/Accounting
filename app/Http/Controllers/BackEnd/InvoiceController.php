<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use App\Models\customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\item;
use App\Models\salereturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index');
    }

    public function Loadall()
    {

        $invoice = Invoice::where('cancel', 0)
            ->where('type', 2)
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();
        return Datatables::of($invoice)
            ->addIndexColumn()
            ->addColumn('customer', function (invoice $invoice) {
                return $invoice->CustomerName->name;
            })
            ->addColumn('payment', function (invoice $invoice) {
                return $invoice->paidinfo()->sum('amount');
            })

            ->addColumn('due', function (invoice $invoice) {
                $netttoal = $invoice->nettotal;
                $payment = $invoice->paidinfo()->sum('amount');
                $due = $netttoal - $payment;
                return $due;

            })
            ->addColumn('user', function (invoice $invoice) {
                return $invoice->username ? $invoice->username->name : 'Deleted User';
            })
            ->addColumn('action', function ($invoice) {

                $button = ' <div class="dropdown">';
                $button .= ' <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded"></i>';
                $button .= '</div>';
                $button .= '<div class="dropdown-menu dropdown-menu-end">';
                $button .= '<a href="' . route('invoice.show', $invoice->id) . '" class="dropdown-item" >View</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('invoice.edit', $invoice->id) . '" class="dropdown-item">Edit</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href="' . route('invoice.pdf', $invoice->id) . '" class="dropdown-item" target="_blank">PDF</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="mail" data-id="' . $invoice->id . '">Send Mail</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a href=' . route('salereturn.create', $invoice->id) . ' class="dropdown-item">Return</a>';
                $button .= '<div class="dropdown-divider"></div>';
                $button .= '<a class="dropdown-item" id="deletedata" data-id="' . $invoice->id . '">Delete</a>';

                $button .= '</div>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function generateUniqueCode()
    {

        $account = new Invoice();
        $transection_id = $account->pluck('id')->last();
        if (!is_null($transection_id)) {
            $invoiceNumber = ($transection_id + 1);
        } else {
            $invoiceNumber = 1;
        }
        return 'INV-' . $invoiceNumber;
    }
    public function create()
    {
        $invoice_number = $this->generateUniqueCode();
        $items = item::all();
        $customers = Customer::all();
        return view('invoice.create', compact('items', 'customers', 'invoice_number'));
    }

    public function store(Request $request)
    {

        $invoice = new Invoice();
        $invoice->invoice_date = $request->invoice_date;
        $invoice->invoice_no = $request->invoice_no;
        $invoice->customer_id = $request->customer_id;
        $invoice->order_no = $request->order_no;
        $invoice->amount = $request->amount;
        $invoice->discount = $request->discount;
        $invoice->nettotal = $request->nettotal;
        $invoice->status = 1;
        $invoice->type = $request->type;
        if ($invoice->type == 1) {
            $invoice->deliverydate = $request->deliverydate;
        }
        $invoice->user_id = auth::id();

        if ($invoice->save()) {

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoice->id;
                $invoiceDetails->customer_id = $request->customer_id;
                $invoiceDetails->item_id = $items['item_id'];
                $invoiceDetails->qty = $items['qty'];
                $invoiceDetails->sale_price = $items['sale_price'];
                $invoiceDetails->purchase_price = $items['purchase_price'];
                $invoiceDetails->amount = $items['amount'];
                $invoiceDetails->save();
            }

            $datareponse = $invoice->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function TransectionNumber()
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

    public function NewCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',

        ]);
        $customer = new customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();
        return redirect()->route('invoice.create');
    }

    public function show($id)
    {

        $paymentinfos = account::where('invoice_id', $id)
            ->where('payment_type', 1)
            ->where('operation_type', 1)
            ->get();
        $transectioNo = $this->TransectionNumber();
        $accountinfos = accountInfo::all();
        $invoice = Invoice::find($id);

        $paymentAmount = account::where('payment_type', 1)
            ->where('operation_type', 1)
            ->where('invoice_id', $id)
            ->sum('amount');

        $nettotal = $invoice->nettotal;
        $due = $nettotal - $paymentAmount;
        $type=$invoice->type==1?'Order':'Invoice';
        return view('invoice.show', compact('invoice', 'accountinfos', 'transectioNo', 'paymentinfos', 'paymentAmount', 'due','type'));
        // dd($invoice);
    }

    public function edit($id)
    {
        $items = item::all();
        $customers = Customer::all();
        $invoice = Invoice::find($id);
        return view('invoice.edit', compact('items', 'invoice', 'customers'));
    }

    public function Update(Request $request)
    {

        $invoice = Invoice::find($request->id);
        $invoice->invoice_date = $request->invoice_date;
        $invoice->invoice_no = $request->invoice_no;
        $invoice->customer_id = $request->customer_id;
        $invoice->order_no = $request->order_no;
        $invoice->amount = $request->amount;
        $invoice->discount = $request->discount;
        $invoice->nettotal = $request->nettotal;
        $invoice->payment = 0;
        $invoice->due = $request->nettotal;
        $invoice->payment_id = 1;
        $invoice->status = 1;
        $invoice->user_id = 1;

        if ($invoice->update()) {

            $invds = InvoiceDetails::where('invoice_id', $invoice->id)->get();
            foreach ($invds as $inv) {
                if (!is_null($inv)) {
                    $inv->delete();
                }
            }

            $tableData = $request->itemtables;
            foreach ($tableData as $items) {
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoice->id;
                $invoiceDetails->customer_id = $request->customer_id;
                $invoiceDetails->item_id = $items['item_id'];
                $invoiceDetails->qty = $items['qty'];
                $invoiceDetails->sale_price = $items['sale_price'];
                $invoiceDetails->purchase_price = $items['purchase_price'];
                $invoiceDetails->amount = $items['amount'];
                $invoiceDetails->save();
            }

            $datareponse = $invoice->id;
        } else {
            $datareponse = 0;
        }
        return response()->json($datareponse);
    }

    public function invoicepdf($id)
    {
        $title = "Invoice";
        $invoice = Invoice::find($id);
        $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'title'));
        return $pdf->stream('invoice.pdf');
    }
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if (!is_null($invoice)) {
            $accounts = account::where('payment_type', 1)
                ->where('operation_type', 1)
                ->where('invoice_id', $id)
                ->get();
            foreach ($accounts as $account) {
                if (!is_null($account)) {
                    $account->delete();
                }
            }
            $salereturns = salereturn::where('invoice_id', $id)->get();
            foreach ($salereturns as $return) {
                if (!is_null($return)) {
                    $return->delete();
                }

            }
            $invoice->delete();
        }

    }
}
