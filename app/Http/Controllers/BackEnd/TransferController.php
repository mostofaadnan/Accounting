<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use App\Models\transfer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
USE PDF;
use Illuminate\Support\Facades\Auth;
class TransferController extends Controller
{
    public function index()
    {

        return view('transfer.index');

    }
    public function loadAll()
    {
        $transfer = transfer::orderBy('id', 'desc')->latest()
            ->get();
        return DataTables::of($transfer)
            ->addIndexColumn()

            ->addColumn('from_account', function (transfer $transfer) {
                return $transfer->fromAccountInfo->account_name;
            })
            ->addColumn('to_account', function (transfer $transfer) {
                return $transfer->toAccountInfo->account_name;
            })
            ->addColumn('amount', function (transfer $transfer) {
                return $transfer->paymentInfo->amount;
            })
            ->addColumn('date', function (transfer $transfer) {
                return $transfer->paymentInfo->date;
            })
            ->addColumn('action', function ($transfer) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('transfer.show', $transfer->id) . '" class="btn btn-sm btn-info" "><i class="fa fa-eye"></i></a>';
                $button .= '<a  href="' . route('transfer.edit', $transfer->id) . '" class="btn btn-sm btn-info" "><i class="fa fa-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $transfer->id . '"><i class="bx bxs-trash"></i></button>';
                $button .= '</div>';
                return $button;
            })

            ->make(true);
    }

    public function create()
    {

        $accountinfos = accountInfo::all();
        return view('transfer.create', compact('accountinfos'));
    }
    public function store(Request $request)
    {

        $request->validate([

            'from_account_id' => 'required',
            'to_acccount_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $transfer = new transfer();
        $transfer->from_account_id = $request->from_account_id;
        $transfer->to_acccount_id = $request->to_acccount_id;
        $transfer->description = $request->description;
        $transfer->from_payment_id = 0;
        $transfer->to_payment_id = 0;
        if ($transfer->save()) {

            //from transection
            $payment_type = 2;
            $account_id = $request->from_account_id;
            $invoice_id = $transfer->id;
            $description = "Transfer";
            $from_payment_id = $this->PaymentStore($request, $payment_type, $account_id, $invoice_id, $description);
            $transfer->from_payment_id = $from_payment_id;
            $transfer->update();
            //To Transection
            $payment_type = 1;
            $account_id = $request->to_acccount_id;
            $invoice_id = $transfer->id;
            $description = "Transfer Recieved";
            $to_payment_id = $this->PaymentStore($request, $payment_type, $account_id, $invoice_id, $description);
            $transfer->to_payment_id = $to_payment_id;
            $transfer->update();
        }
        return redirect()->route('transfer.show', $transfer->id);

    }

    public function PaymentStore($request, $payment_type, $account_id, $invoice_id, $description)
    {

        $transfeNo = $this->TransectionNumber();
        $account = new account();
        $account->payment_type = $payment_type;
        $account->operation_type = 4;
        $account->transection_no = $transfeNo;
        $account->account_id = $account_id;
        $account->date = $request->date;
        $account->description = $description;
        $account->payment_method = $request->payment_method;
        $account->amount = $request->amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->invoice_id = $invoice_id;
        $account->status = 1;
        $account->user_id= auth::id();
        $account->save();
        return $account->id;
    }
    public function TransectionNumber()
    {
        /*  do {
        $code = random_int(100000, 999999);
        } while (clientInvoice::where("id", "=", $code)
        ->where('client_id', $id)
        ->first());

        return $code; */

        $Invoice = account::latest()
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

        $transfer = transfer::find($id);
        return view('transfer.show', compact('transfer'));

    }
    public function edit($id)
    {

        $transfer = transfer::find($id);
        $accountinfosfroms = accountInfo::where('id', $transfer->from_account_id)->get();
        $accountinfostos = accountInfo::where('id', $transfer->to_acccount_id)->get();
        return view('transfer.edit', compact('transfer', 'accountinfosfroms', 'accountinfostos'));

    }

    public function update(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required',
            'to_acccount_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $transfer = transfer::find($request->transfer_id);
        $transfer->from_account_id = $request->from_account_id;
        $transfer->to_acccount_id = $request->to_acccount_id;
        $transfer->description = $request->description;
        if ($transfer->update()) {

            //from transection
            $this->Paymentpdate($request, $transfer->from_payment_id);
            //To Transection
            $this->Paymentpdate($request, $transfer->to_payment_id);

        }
        return redirect()->route('transfer.show', $transfer->id);
    }
    public function Paymentpdate($request, $id)
    {
        $account = account::find($id);
        $account->date = $request->date;
        $account->payment_method = $request->payment_method;
        $account->amount = $request->amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->status = 1;
        $account->update();
        return $account->id;
    }

    public function destroy($id)
    {

        $transfer = transfer::find($id);
        if (!is_null($transfer)) {

            $fromtransection = account::find($transfer->from_payment_id);
            if (!is_null($fromtransection)) {
                $fromtransection->delete();
            }

            $totransection = account::find($transfer->to_payment_id);
            if (!is_null($totransection)) {
                $totransection->delete();
            }

            $transfer->delete();
        }

    }

    public function TransferPdf($id)
    {
        $title="Transfer";
        $transfer = transfer::find($id);
        $pdf = PDF::loadView('pdf.transfer', compact('transfer','title'));
        return $pdf->stream('transfer.pdf');

    }
}
