<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use Illuminate\Http\Request;
use PDF;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{

    public function index()
    {
        $openingbalance = accountInfo::all()->sum('opening_balance');
        $credit = account::where('payment_type', 1)
            ->sum('amount');
        $debit = account::where('payment_type', 2)
            ->sum('amount');
        $balance = ($credit - $debit);
        $currentbalance = $balance + $openingbalance;
        return view('payment.index', compact('credit', 'debit', 'currentbalance'));
    }
    public function loadAll()
    {
        $account = account::orderBy('id', 'desc')->latest()
            ->get();
        return Datatables::of($account)
            ->addIndexColumn()

            ->addColumn('account', function (account $account) {
                return $account->AccountInfo->account_name;
            })
            ->addColumn('type', function (account $account) {
                return $account->payment_type == 1 ? 'income' : 'Expense';
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

            ->addColumn('action', function ($account) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('account.payment.show', $account->id) . '" class="btn btn-sm btn-info" "><i class="fadeIn animated bx bx-arrow-to-right"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $account->id . '"><i class="bx bxs-trash"></i></button>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
            'transection_no' => 'required',
            'account_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);
        if ($request->payment_type == 1) {
            $description = "Invoice Payment";
        } else {
            $description = "Purchase Payment";
        }

        $account = new account();
        $account->payment_type = $request->payment_type;
        $account->operation_type = $request->operation_type;
        $account->transection_no = $request->transection_no;
        $account->account_id = $request->account_id;
        $account->date = $request->date;
        $account->description = $description;
        $account->payment_method = $request->payment_method;
        $account->amount = $request->amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->invoice_id = $request->invoice_id;
        $account->status = 1;
        $account->user_id= auth::id();
        $account->save();

        if ($request->payment_type == 1) {
            return redirect()->route('invoice.show', $account->invoice_id);
        } else {
            return redirect()->route('purchase.show', $account->invoice_id);
        }
    }

    public function show($id)
    {

        $account = account::find($id);
        $type = $account->operation_type;
        switch ($type) {
            case 1:
                $paidinfo = $account->InvoiceNo->CustomerName;
                $operationinfo = $account->InvoiceNo;
                break;
            case 2:
                $paidinfo = $account->purchaseNo->VendorName;
                $operationinfo = $account->purchaseNo;
                break;
            case 3:
                $paidinfo = $account->ExpenseInfo;
                $operationinfo = $account->ExpenseInfo;
                break;
            case 4:
                $paidinfo = $account->Transfeinfo;
                $operationinfo = $account->Transfeinfo;
                break;
            default:
                break;
        }
        return view('payment.show', compact('account', 'paidinfo', 'operationinfo'));

    }

    public function RecieptdPdf($id)
    {
        $account = account::find($id);
        $type = $account->operation_type;
        switch ($type) {
            case 1:
                $paidinfo = $account->InvoiceNo->CustomerName;
                $operationinfo = $account->InvoiceNo;
                break;
            case 2:
                $paidinfo = $account->purchaseNo->VendorName;
                $operationinfo = $account->purchaseNo;
                break;
            case 3:
                $paidinfo = $account->ExpenseInfo;
                $operationinfo = $account->ExpenseInfo;
                break;
            case 4:
                $paidinfo = $account->Transfeinfo;
                $operationinfo = $account->Transfeinfo;
                break;
            default:
                break;
        }
        $title = 'Reciept';
        $pdf = PDF::loadView('pdf.reciept', compact('account', 'paidinfo', 'operationinfo', 'title'));
        return $pdf->stream('invoice.pdf');
    }

}
