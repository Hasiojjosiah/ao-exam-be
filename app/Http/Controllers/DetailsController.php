<?php

namespace App\Http\Controllers;

use App\Models\Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailsController extends Controller
{

    public function index()
    {
        $index = Details::select('id', 'name', 'email', 'ip_address', 'country', 'city')
            ->get();

        return response()->json($index);
    }


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

    public function update(Request $request, $id)
    {
        $request['id'] = $id;
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'ip_address' => ['required', 'ip'],
            'country' => ['string'],
            'city' => ['string'],
        ]);

        DB::beginTransaction();

        try {
            $data = [];


            $data["name"] = $request->input('name');
            $data["email"] = $request->input('email');
            $data["ip_address"] = $request->input('ip_address');

            if ($request->has('country')) {
                $data["country"] = $request->input('country');
            }

            if ($request->has('city')) {
                $data["city"] = $request->input('city');
            }


            $update = Details::where('id', $request->input('id'))
                ->update($data);
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

        $message = [
            "message" => "Succesfully Updated.",
        ];
        return response()->json($message);
    }

    public function show($id)
    {
        $show = Details::where('id', $id)
            ->select('id', 'name', 'email', 'ip_address', 'country', 'city')
            ->first();

        return response()->json($show);
    }

    public function remove($id)
    {
        $remove = Details::where('id', $id)
            ->delete();

        return response()->json($remove);
    }
}
