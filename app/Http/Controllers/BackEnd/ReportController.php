<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\Invoice;
use App\Models\purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function index()
    {
        return view('report.index');
    }

    public function reportQuery(Request $request)
    {

        $request->validate([
            'todate' => 'required',
            'fromdate' => 'required',
        ]);

        $type = $request->inputtype;
        Session::put('todate', $request->todate);
        Session::put('fromdate', $request->fromdate);
        switch ($type) {
            case "1":
                return redirect()->route('report.purchseView');
                break;
            case "2":
                return redirect()->route('report.purchsePaymentView');
                break;
            case "3":
                return redirect()->route('report.invoiceView');
                break;
            case "4":
                return redirect()->route('report.invoicePaymentView');
                break;
            case "5":
                return redirect()->route('report.transectionView');
                break;
            default:
                break;
        }
    }
//Purchase

    public function purchaseCreate()
    {

        $inputtype = 1;
        $type = "Purchase";
        return view('report.create', compact('inputtype', 'type'));
    }

    public function purchseView()
    {
        return view('report.purchase');
    }

    public function purchaseData()
    {
        $todate = Session::get('todate');
        $fromdate = Session::get('fromdate');
        $purchase = purchase::where('cancel', 0)
            ->whereBetween('purchase_date', array($todate, $fromdate))
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        Session::put('purchaseData', $purchase);

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
            ->make(true);

    }
    public function purchasePdf()
    {

        $data['purchase'] = Session::get('purchaseData');
        $data['todate'] = Session::get('todate');
        $data['fromdate'] = Session::get('fromdate');
        $title = "Purchase Report";

        $pdf = PDF::loadView('pdf.report.purchase', compact('data', 'title'));
        return $pdf->stream('purchase.pdf');
    }

    //Purchase Payment

    public function purchasePaymentCreate()
    {

        $inputtype = 2;
        $type = "Purchase Payment";
        return view('report.create', compact('inputtype', 'type'));
    }

    public function purchsePaymentView()
    {
        return view('report.purchasePayment');
    }

    public function purchasePaymentData()
    {
        $todate = Session::get('todate');
        $fromdate = Session::get('fromdate');
        $purchasePayment = account::where('operation_type', 2)
            ->whereBetween('date', array($todate, $fromdate))
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        Session::put('purchasePaymentData', $purchasePayment);

        return Datatables::of($purchasePayment)
            ->addIndexColumn()
            ->addColumn('account', function (account $purchasePayment) {
                return $purchasePayment->AccountInfo->account_name;
            })
            ->addColumn('purchase_no', function (account $purchasePayment) {
                return $purchasePayment->purchaseNo->purchase_no;
            })
            ->addColumn('purchase_date', function (account $purchasePayment) {
                return $purchasePayment->purchaseNo->purchase_date;
            })
            ->addColumn('vendor', function (account $purchasePayment) {
                return $purchasePayment->purchaseNo->VendorName->name;
            })

            ->make(true);

    }
    public function purchasePaymentPdf()
    {

        $data['purchasePayment'] = Session::get('purchasePaymentData');
        $data['todate'] = Session::get('todate');
        $data['fromdate'] = Session::get('fromdate');
        $title = "Purchase Payment Report";

        $pdf = PDF::loadView('pdf.report.purchasepayment', compact('data', 'title'));
        return $pdf->stream('purchase.pdf');
    }

    //Invoice
    public function invoiceCreate()
    {

        $inputtype = 3;
        $type = "Invoice";
        return view('report.create', compact('inputtype', 'type'));
    }

    public function invoiceView()
    {
        return view('report.invoice');
    }

    public function invoiceData()
    {
        $todate = Session::get('todate');
        $fromdate = Session::get('fromdate');
        $invoice = Invoice::where('cancel', 0)
            ->whereBetween('invoice_date', array($todate, $fromdate))
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        Session::put('invoiceData', $invoice);

        return Datatables::of($invoice)
            ->addIndexColumn()
            ->addColumn('customer', function (Invoice $Invoice) {
                return $Invoice->CustomerName->name;
            })
            ->addColumn('payment', function (Invoice $Invoice) {
                return $Invoice->paidinfo()->sum('amount');
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
            ->make(true);

    }
    public function invoicePdf()
    {

        $data['invoice'] = Session::get('invoiceData');
        $data['todate'] = Session::get('todate');
        $data['fromdate'] = Session::get('fromdate');
        $title = "invoice Report";

        $pdf = PDF::loadView('pdf.report.invoice', compact('data', 'title'));
        return $pdf->stream('invoice.pdf');
    }

    //Invoice Payment

    public function invoicePaymentCreate()
    {

        $inputtype = 4;
        $type = "Invoice Payment";
        return view('report.create', compact('inputtype', 'type'));
    }

    public function invoicePaymentView()
    {
        return view('report.invoicePayment');
    }

    public function invoicePaymentData()
    {
        $todate = Session::get('todate');
        $fromdate = Session::get('fromdate');
        $invoicePayment = account::where('operation_type', 1)
            ->whereBetween('date', array($todate, $fromdate))
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        Session::put('invoicePaymentData', $invoicePayment);

        return Datatables::of($invoicePayment)
            ->addIndexColumn()
            ->addColumn('account', function (account $invoicePayment) {
                return $invoicePayment->AccountInfo->account_name;
            })
            ->addColumn('invoice_no', function (account $invoicePayment) {
                return $invoicePayment->InvoiceNo->invoice_no;
            })
            ->addColumn('invoice_date', function (account $invoicePayment) {
                return $invoicePayment->InvoiceNo->invoice_date;
            })
            ->addColumn('customer', function (account $invoicePayment) {
                return $invoicePayment->InvoiceNo->CustomerName->name;
            })

            ->make(true);

    }
    public function invoicePaymentPdf()
    {

        $data['invoicePayment'] = Session::get('invoicePaymentData');
        $data['todate'] = Session::get('todate');
        $data['fromdate'] = Session::get('fromdate');
        $title = "Purchase Payment Report";

        $pdf = PDF::loadView('pdf.report.invoicepayment', compact('data', 'title'));
        return $pdf->stream('invoicepayment.pdf');
    }

    //transection
    public function transectionCreate()
    {

        $inputtype = 5;
        $type = "Transection";
        return view('report.create', compact('inputtype', 'type'));
    }

    public function transectionView()
    {
        return view('report.transection');
    }

    public function transectionData()
    {
        $todate = Session::get('todate');
        $fromdate = Session::get('fromdate');
        $transection = account::whereBetween('date', array($todate, $fromdate))
            ->orderBy('id', 'DESC')
            ->latest()
            ->get();

        Session::put('transectionData', $transection);

        return Datatables::of($transection)
            ->addIndexColumn()
            ->addColumn('account', function (account $invoicePayment) {
                return $invoicePayment->AccountInfo->account_name;
            })
            ->addColumn('document', function (account $account) {
                $type = $account->operation_type;

                switch ($type) {
                    case 1:
                        return $account->InvoiceNo->CustomerName->name;
                        break;
                    case 2:
                        return $account->purchaseNo->VendorName->name;
                        break;
                    case 3:
                        return $account->ExpenseInfo->description;
                        break;
                    case 4:
                        return $account->Transfeinfo->description;
                        break;
                    default:
                        break;
                }
            })
            ->addColumn('type', function (account $account) {
                return $account->payment_type == 1 ? 'income' : 'Expense';
            })
            ->make(true);

    }
    public function transectionPdf()
    {

        $data['transection'] = Session::get('transectionData');
        $data['todate'] = Session::get('todate');
        $data['fromdate'] = Session::get('fromdate');
        $title = "Transection Report";

        $pdf = PDF::loadView('pdf.report.transection', compact('data', 'title'));
        return $pdf->stream('transection.pdf');
    }
}
