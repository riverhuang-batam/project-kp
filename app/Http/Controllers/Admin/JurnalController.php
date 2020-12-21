<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use Illuminate\Http\Request;
use DB;
use DataTables;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jurnal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pc = 'JR'.date('YmdHis');
        return view('jurnal.form', compact('pc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Jurnal::rules());
        $request->validate(JurnalDetail::rules());
        
        try {
            DB::beginTransaction();
            $akuns = $request->input('akuns');
            $jurnal = Jurnal::create(request()->except(['akuns']));

            $jurnalDetail = [];
            foreach($akuns as $key => $akun) {
                $jurnalDetail[] = [
                    'akun_id' => $akun['akun_id'],
                    'jurnal_id' => $jurnal->id,
                    'description' => $akun['description'],
                    'debit' => $akun['debit'],
                    'credit' => $akun['credit'],
                ];
            }

            // DB::table('jurnal_details')->insert($jurnalDetail);
            $jurnal->jurnalDetails()->createMany($jurnalDetail);
            DB::commit();
            return redirect()->route('jurnals.index')->with('status', 'New jurnal created successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('jurnals.index')->with('error', 'Fail to create jurnal, please try again!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurnal $jurnal)
    {
        $jurnal->jurnalDetails;
        return view('jurnal.form', compact('jurnal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jurnal $jurnal)
    {
        $request->validate(Jurnal::rules());
        $request->validate(JurnalDetail::rules());
        try {
            DB::beginTransaction();

            $akuns = $request->input('akuns');
            $jurnal->update($request->except(['akuns']));

            $jurnalDetails = JurnalDetail::where('jurnal_id', $jurnal->id)->get();
            $updateDetail = [];
            $inputId = [];
            foreach($akuns as $key => $akun) {
                array_push($inputId, $akun['detail_id']);
                $updateDetail = [
                    'akun_id' => $akun['akun_id'],
                    'jurnal_id' => $jurnal->id,
                    'description' => $akun['description'],
                    'debit' => $akun['debit'],
                    'credit' => $akun['credit'],
                ];
                $detail = JurnalDetail::updateOrCreate(
                    ['id' => $akun['detail_id']],
                    $updateDetail,
                );
            }
            foreach($jurnalDetails as $jurnalDetail) {
                if(!in_array($jurnalDetail->id, $inputId)) {
                    JurnalDetail::destroy($jurnalDetail->id);
                }
            }
            DB::commit();
            return redirect()->route('jurnals.index')->with('status', 'Jurnal updated successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('jurnals.index')->with('error', 'Fail to update jurnal, please try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurnal  $jurnal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $jurnal = Jurnal::find($id);
        $jurnal->jurnalDetails()->delete();
        $jurnal->delete();
    }

    public function jurnalDataTable(Request $request){
        $data = Jurnal::query()->get();
        return DataTables::of($data)
            ->addColumn('action', function($data){
              $buttonAll = '
              <div class="d-flex flex-row justify-content-center">
                <div class="dropdown mr-2">
                  <button class="btn btn-primary btn-rounded btn-sm dropdown-toggle" type="button" id="optionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="optionMenu">
                    <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                    <button class="dropdown-item" type="button" id="edit" data-id='.$data->id.'>Edit</button>
                    <button class="dropdown-item" type="button" id="delete" data-id='.$data->id.'>Delete</button>
                  </div>
                </div>';
              return $buttonAll;
            })
            ->rawColumns(['action'])
            ->make(true);
      }
}
