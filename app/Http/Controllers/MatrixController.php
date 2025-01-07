<?php

namespace App\Http\Controllers;

use App\Models\tb_matrix;
use Illuminate\Http\Request;
use TbMatrix;
use Yajra\DataTables\Facades\DataTables;

class MatrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            "id" => "id",
            "panjang" => "panjang",
            "tinggi" => "tinggi",
        ];

        $datatable = DataTables::of(tb_matrix::query())
            // ->filter(function ($query) use ($request, $columns) {
            //     $this->filterColumn($columns, $request, $query);
            // })
            ->escapeColumns([])
            ->make(true)->getData(true);
        $response = responseDatatableSuccess(__('messages.read-success'), $datatable);
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "panjang" => "required",
            "tinggi" => "required",
        ];

        $matrix = tb_matrix::select('panjang')->where('panjang',$request->panjang)->where('tinggi',$request->tinggi)->get();

        if ($matrix->isNotEmpty()) {
            $response = responseFail(__('messages.delete-fail'), 'Data cannot created because the data same');
            return response()->json($response, 500);
        }

        $this->validate($request, $rules);
        $params = $request->only("panjang", "tinggi");

        try {
            $model = tb_matrix::create($params);
            $response = responseSuccess(__('messages.create-success'), $model);
            return response()->json($response, 201);
        } catch (\Exception $ex) {
            $response = responseFail(__('messages.create-fail'), $ex->getMessage());
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $model = tb_matrix::where('id',$id)->firstOrFail();
        $matrix = [];
        for ($i = 1; $i <= $model->panjang; $i++) {
            for ($j = 1; $j <= $model->tinggi; $j++) {
                $matrix[] = [
                    "x" => $i,
                    "y" => $j,
                    "value" => rand(1, 10),
                ];
            }
        }
        $response = [
            "id" => $model->id,
            "panjang" => $model->panjang,
            "tinggi" => $model->tinggi,
            "randomized_matrix" => $matrix,
        ];
        return response()->json(
            responseSuccess(__("messages.read-success"), $response)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = tb_matrix::where('id',$id)->firstOrFail();

        $rules = [
            "panjang" => "required",
            "tinggi" => "required"
        ];

        $this->validate($request, $rules);


        $matrix = tb_matrix::select('panjang')->where('panjang',$request->panjang)->where('tinggi',$request->tinggi)->get();

        if ($matrix->isNotEmpty()) {
            $response = responseFail(__('messages.delete-fail'), 'Data cannot created because the data same');
            return response()->json($response, 500);
        }

        $params = $request->only("panjang", "tinggi");

        try {
            $model->update($params);
            $response = responseSuccess(__('messages.update-success'), $model);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            $response = responseFail(__('messages.update-fail'), $ex->getMessage());
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = tb_matrix::where('id',$id)->firstOrFail();

        try {
            $model->delete();
            $response = responseSuccess(__('messages.delete-success'), $model);
            return response()->json($response, 200);
        } catch (\Exception $ex) {
            $response = responseFail(__('messages.delete-fail'), $ex->getMessage());
            return response()->json($response, 500);
        }
    }
}
