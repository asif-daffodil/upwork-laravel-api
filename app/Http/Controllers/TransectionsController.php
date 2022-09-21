<?php

namespace App\Http\Controllers;

use App\Models\transections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TransectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($duration = 7, Request $request)
    {
        // eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiMSIsImVtYWlsIjoiYWJpckBkaXB0aS5jb20uYmQifQ.8vTN5J-3Xihery6bR5PtDqH0lndbzqiRaikJNM-jZn0
        $header = $request->header('Authorization');
        if ($header == "") {
            $data = ["success" => false, "errors" => [401], "data" => null];
            return response()->json($data, 401);
        } else {
            $key = "asif125";
            $jwtData = JWT::decode($header, new Key($key, 'HS256'));
            if (!isset($jwtData)) {
                $data = ["success" => false, "errors" => [401], "data" => null];
                return response()->json($data, 401);
            } else {
                $user_id = $jwtData->user_id;
                $trns = transections::whereDate('created_at', ">", Carbon::now()->subDays($duration))->where('user_id', $user_id)->get(["sales", "paid", "unpaid", "cancle"]);
                $totalSale = $trns->sum('sales');
                $saleCount = $trns->where('sales', '!=', 0)->count();
                $turnOver = $totalSale / $saleCount;
                $paidCount = $trns->where('paid', '!=', false)->count();
                $unPaidCount = $trns->where('unpaid', '!=', false)->count();
                $cancleCount = $trns->where('cancle', '!=', false)->count();
                $data = ["success" => true, "errors" => null, "data" => [
                    "pagetitle" => "Shop Statistics",
                    "saleCount" => $saleCount,
                    "totalSale" => $totalSale,
                    "turnOver" => $turnOver,
                    "paidCount" => $paidCount,
                    "unPaidCount" => $unPaidCount,
                    "cancleCount" => $cancleCount,
                    "transectionDetails" => [$trns]
                ]];
                return response()->json($data, 200);
            }
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transections  $transections
     * @return \Illuminate\Http\Response
     */
    public function show(transections $transections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transections  $transections
     * @return \Illuminate\Http\Response
     */
    public function edit(transections $transections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transections  $transections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transections $transections)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transections  $transections
     * @return \Illuminate\Http\Response
     */
    public function destroy(transections $transections)
    {
        //
    }
}
