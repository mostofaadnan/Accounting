<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense.index');
    }
    public function LoadAll()
    {
        $Expense = Expense::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($Expense)
            ->addIndexColumn()

            ->addColumn('transection_no', function (Expense $Expense) {
                return $Expense->PaymentInfo->transection_no;
            })
            ->addColumn('amount', function (Expense $Expense) {
                return $Expense->PaymentInfo->amount;
            })
            ->addColumn('date', function (Expense $Expense) {
                return $Expense->PaymentInfo->date;
            })
            ->addColumn('action', function ($Expense) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('account.payment.show', $Expense->payment_id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-eye"></i></a>';
                $button .= '<a  href="' . route('expense.edit', $Expense->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $Expense->id . '"><i class="bx bxs-trash"></i></button>';
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
        $accountinfos = accountInfo::all();
        $transection_no = $this->TransectionNumber();
        return view('expense.create', compact('accountinfos', 'transection_no'));
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'transection_no' => 'required|numeric',
            'account_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $amount = $request->amount;
        $account = new account();
        $account->payment_type = 2;
        $account->operation_type = 3;
        $account->transection_no = $request->transection_no;
        $account->account_id = $request->account_id;
        $account->date = $request->date;
        $account->description = "Expense";
        $account->payment_method = $request->payment_method;
        $account->amount = $amount;
        $account->payment_descripiton = $request->payment_descripiton;
        $account->invoice_id = 0;
        $account->status = 1;
        $account->user_id= auth::id();
        if ($account->save()) {
            $expense = new Expense();
            $expense->name = $request->bill_to_name;
            $expense->address = $request->bill_to_address;
            $expense->phone = $request->bill_to_phone;
            $expense->email = $request->bill_to_email;
            $expense->description = $request->description;
            $expense->payment_id = $account->id;
            $expense->user_id= auth::id();
            $expense->save();

            $account->invoice_id = $expense->id;
            $account->update();

        }
        return redirect()->route('account.payment.show', $account->id);
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
        $expense = Expense::find($id);
        $accountinfos = accountInfo::where('id',$expense->PaymentInfo->account_id)->get();
        return view('expense.edit', compact('expense','accountinfos'));
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
        $request->validate([
            'date' => 'required',
            'amount' => 'required',
        ]);

        $amount = $request->amount;
        $account = account::find($request->payment_id);
        $account->date = $request->date;
        $account->amount = $amount;
        $account->payment_descripiton = $request->payment_descripiton;
        if ($account->update()) {
            $expense = Expense::find($request->expense_id);
            $expense->name = $request->bill_to_name;
            $expense->address = $request->bill_to_address;
            $expense->phone = $request->bill_to_phone;
            $expense->email = $request->bill_to_email;
            $expense->description = $request->description;
            $expense->update();
        }
        return redirect()->route('account.payment.show', $account->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if(!is_null($expense)){
            $account=account::find($expense->payment_id);
            if(!is_null($account)){
                $account->delete();
            }
            $expense->delete();
        }
    }
}