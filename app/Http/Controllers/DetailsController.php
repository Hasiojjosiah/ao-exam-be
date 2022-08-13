<?php

namespace App\Http\Controllers;

use App\Models\Details;
use Illuminate\Http\Request;
use DB;

class DetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $index = Details::select('id', 'name', 'email', 'ip_address', 'country', 'city')
            ->get();

        return response()->json($index);
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
            'name' => ['required', 'unique:details'],
            'email' => ['required', 'email:rfc,dns', 'unique:details'],
            'ip_address' => ['required', 'ip'],
            'country' => ['string'],
            'city' => ['string'],
        ]);

        DB::beginTransaction();

        try {
            $store = new Details;
            $store->name = $request->input('name');
            $store->email = $request->input('email');
            $store->ip_address = $request->input('ip_address');

            if ($request->has('country')) {
                $store->country = $request->input('country');
            }

            if ($request->has('city')) {
                $store->country = $request->input('city');
            }

            $store->save();
        } catch (\Throwable $th) {

            DB::rollBack();
            $message = [
                "message" => "Something went wrong.",
                "errors" => [
                    "server" => [
                        $th->getMessage()
                    ]
                ]
            ];

            return response()->json($message, 500);
        }

        DB::commit();

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Details  $Details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Details::where('id', $id)
            ->select('id', 'name', 'email', 'ip_address', 'country', 'city')
            ->first();

        return response()->json($show);
    }
}
