<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // Move to service and repository later on
    public function index()
    {
        try {
            $data = Term::all();

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

    public function translate(Request $request)
    {
        $payload = $request->all();

        $search = $payload['search'];
        $language = $payload['language'];

        $result = Term::query()
            ->select(['id', 'jahai_term', 'malay_term', 'english_term', 'description', 'term_category'])
            ->when($language == 'Jahai', function ($q) use ($search) {
                $q->where("jahai_term", "LIKE", "%{$search}%");
            })
            ->when($language == 'Malay', function ($q) use ($search) {
                $q->where("malay_term", "LIKE", "%{$search}%");
            })
            ->when($language == 'English', function ($q) use ($search) {
                $q->where("english_term", "LIKE", "%{$search}%");
            })
            ->get();

        // $result = [
        //     'status'      => 200,
        //     'message'     => 'Success',
        //     'translation' => $data
        // ];

        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        try {
            $data = Term::create($payload);

            $result = [
                'status'    => 200,
                'message'   => 'Success',
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
