<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\item;
use Yajra\DataTables\DataTables;

class Stockcontroller extends Controller
{
    public function index()
    {

        return view('item.stock');
    }
    public function LoadAll()
    {
        $item = item::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($item)
            ->addIndexColumn()
            ->addColumn('name', function ($item) {
               
                return $item->CategoryName->name.' '.$item->name;
            })
            ->addColumn('stock', function ($item) {
                $openigqty = $item->opening_stock;
                $invoice = $item->QuantityOutBySale()->sum('qty');
                $invoiceReturn = $item->QuantityOutBySaleReturn()->sum('qty');
                $totalinvoiceqty = $invoice - $invoiceReturn;
                $purchase = $item->QuantityOutByPurchase()->sum('qty');
                $stock = $openigqty + ($purchase - $totalinvoiceqty);
                return $stock.' kg' ;
            })
            ->addColumn('purchase', function ($item) {
                $purchase = $item->QuantityOutByPurchase()->sum('qty');
                return $purchase.' Kg';
            })
            ->addColumn('invoice', function ($item) {
                $invoice = $item->QuantityOutBySale()->sum('qty');
                return $invoice.' Kg';
            })

            ->make(true);
    }
}