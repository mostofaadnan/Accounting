<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }
    public function LoadAll(Request $request)
    {
        $category = category::orderBy('id', 'desc')
            ->latest()
            ->get();
        return Datatables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                $button = ' <div class="btn-group">';
                $button .= '<a  href="' . route('category.edit', $category->id) . '" class="btn btn-sm btn-info" "><i class="bx bxs-edit"></i></a>';
                $button .= '<button  class="btn btn-sm btn-danger" id="deletedata" data-id="' . $category->id . '"><i class="bx bxs-trash"></i></button>';
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
        return view('category.create');
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
            'name' => 'required',
        ]);
        $category = new category();
        $category->name = $request->name;
        if ($category->save()) {
            Session()->flash('success', 'New Category successfully');

        } else {
            Session()->flash('erors', 'Fail To save New category');
        }
        return redirect()->route('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=category::find($id);
        return view('category.edit',compact('category'));   
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
            'name' => 'required',
        ]);
        $category =category::find($request->id);
        $category->name = $request->name;
        if ($category->update()) {
            Session()->flash('success', 'Category update successfully');

        } else {
            Session()->flash('erors', 'Fail To Update category');
        }
        return redirect()->route('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=category::find($id);
        if(!is_null($category)){
            $category->delete();
        }
    }
}
