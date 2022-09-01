<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\account;
use App\Models\accountInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
class AccountInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accountinfo.index');
    }
    public function LoadAll(Request $request)
    {
        $accountInfo = accountInfo::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($accountInfo)
            ->addIndexColumn()

            ->addColumn('current_balance', function (accountInfo $accountInfo) {
                $credit = account::where('account_id', $accountInfo->id)
                    ->where('payment_type', 1)
                    ->sum('amount');
                $debit = account::where('account_id', $accountInfo->id)
                    ->where('payment_type', 2)
                    ->sum('amount');
                $currentbalance = $credit - $debit;
                return $currentbalance;
            })

            ->addColumn('action', function ($accountInfo) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('account.show', $accountInfo->id) . '" class="btn btn-sm btn-info" "><i class="fadeIn animated bx bx-arrow-to-right"></i></a>';
                $button .= '<a  href="' . route('account.edit', $accountInfo->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $accountInfo->id . '"><i class="bx bxs-trash"></i></button>';
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
        return view('accountinfo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accountinfo = new accountInfo();
        $accountinfo->account_type = $request->account_type;
        $accountinfo->account_name = $request->account_name;
        $accountinfo->account_number = $request->account_number;
        $accountinfo->bank_name = $request->bank_name;
        $accountinfo->bank_phone = $request->bank_phone;
        $accountinfo->bank_address = $request->bank_address;
        $accountinfo->opening_balance = $request->opening_balance;
        $accountinfo->status = 1;
        $accountinfo->user_id= auth::id();
        if ($accountinfo->save()) {
            Session()->flash('success', 'New Account Save successfully');

        } else {
            Session()->flash('erors', 'Fail To save New Account');
        }
        return redirect()->route('accounts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $accountinfo = accountInfo::find($id);
        $credit = account::where('account_id', $id)
            ->where('payment_type', 1)
            ->sum('amount');
        $debit = account::where('account_id', $id)
            ->where('payment_type', 2)
            ->sum('amount');
        $balance = ($credit - $debit);
        $openingbalance = $accountinfo->opening_balance;
        $currentbalance = $balance + $openingbalance;
        return view('accountInfo.show', compact('accountinfo', 'credit', 'debit', 'currentbalance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accountinfo = accountInfo::find($id);
        return view('accountinfo.edit', compact('accountinfo'));
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
        $accountinfo = accountInfo::find($request->id);
        $accountinfo->account_type = $request->account_type;
        $accountinfo->account_name = $request->account_name;
        $accountinfo->account_number = $request->account_number;
        $accountinfo->bank_name = $request->bank_name;
        $accountinfo->bank_phone = $request->bank_phone;
        $accountinfo->bank_address = $request->bank_address;
        $accountinfo->opening_balance = $request->opening_balance;
        $accountinfo->status = 1;
        if ($accountinfo->update()) {
            Session()->flash('success', 'New Account Save successfully');

        } else {
            Session()->flash('erors', 'Fail To save New Account');
        }
        return redirect()->route('accounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function LoadAllAccountDetails($id)
    {
        $account = account::orderBy('id', 'desc')
            ->where('account_id', $id)
            ->latest()
            ->get();
        return Datatables::of($account)
            ->addIndexColumn()

            ->addColumn('current_balance', function (account $account) {
                return "0";
            })
            ->addColumn('type', function (account $account) {
                return $account->payment_type==1?'income':'Expense';
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
            ->make(true);
    }
}
