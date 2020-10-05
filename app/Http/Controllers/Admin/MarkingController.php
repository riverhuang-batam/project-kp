<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marking;
use Illuminate\Http\Request;
use DataTables;

class MarkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $markings = Marking::all();
        return view('marking.index', compact('markings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marking.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Marking::rules());

        Marking::create(request()->all());
        return redirect()->route('markings.index')->with('status', 'New marking successfully added');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marking  $marking
     * @return \Illuminate\Http\Response
     */
    public function show(Marking $marking)
    {
        $marking = Marking::find($marking->id);
        return view('marking.show', compact('marking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marking  $marking
     * @return \Illuminate\Http\Response
     */
    public function edit(Marking $marking)
    {
        $marking = Marking::find($marking->id);
        return view('marking.form', compact('marking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marking  $marking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marking $marking)
    {
        $request->validate(Marking::rules());
        $marking->update(request()->all());
        return redirect()->route('markings.index')->with('status', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marking  $marking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        Marking::find($id)->delete();
    }

    public function markingDataTable(Request $request)
    {
        return DataTables::of(Marking::query()->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '
            <a class="btn btn-warning btn-sm" id="edit" data-id=' . $data->id . '>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm text-light" id="delete" data-id=' . $data->id . '>Delete</a>
          ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function markingSelect(Request $request){
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }

        $markings = Marking::select('id','name')->where('name', 'like', '%' .$term . '%')->limit(20)->get();

        $formattedMarking = [];
        foreach($markings as $marking){
            $formattedMarking[] = ['id'=>$marking->id, 'text'=>$marking->name];
        }

        return response()->json($formattedMarking);
    }
}