<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use DataTables;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('akun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akun.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Akun::rules());
        $akun = Akun::create($request->all());

        return redirect()->route('akuns.index')->with('status', 'New Akun successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function show(Akun $akun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function edit(Akun $akun)
    {
        return view('akun.form', compact('akun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Akun $akun)
    {
        $request->validate(Akun::rules());
        $akun->update($request->all());

        return redirect()->route('akuns.index')->with('status', 'Akun successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Akun  $akun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Akun $akun)
    {
        //
    }

    public function akunDataTable(Request $request)
    {
        return DataTables::of(Akun::query()->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '
            <a class="btn btn-warning btn-sm btn-rounded text-dark" id="edit" data-id=' . $data->id . '>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm btn-rounded text-light" id="delete" data-id=' . $data->id . '>Delete</a>
          ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function akunSelect(Request $request)
    {
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }

        $akuns = Akun::where('name', 'like', '%' .$term. '%')
            ->orWhere('code', 'like', '%' .$term. '%')
            ->limit(10)
            ->get();

        $formattedItems = [];
        foreach($akuns as $akun) {
            $formattedItems[] = ['id' => $akun->id, 'text' => "(" .$akun->code. ") ". $akun->name];
        }

        return response()->json($formattedItems);
    }
}
