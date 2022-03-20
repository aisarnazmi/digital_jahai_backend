<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // Move to service and repository later on

    public function store(Request $request)
    {
        $payload = $request->all();

        try {
            $data = Term::create($payload);

            $result = [
                'status'    => 200,
                'message'   => 'Success',
                'data'      => $data
            ];

            return response()->json($result, 200);

        } catch (\Throwable $th) {
           
            $result = [
                'status'    => 500,
                'message'   => 'Failed'
            ];

            return response()->json($result, 500);
        }
    }
}
