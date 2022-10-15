<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

class LibraryController extends Controller
{
    // Move to service and repository later on
    public function index(Request $request)
    {
        $payload = new Fluent($request->all());

        try {
            $search = $payload->get('search');

            $result = Term::query()
                ->when(($search && $search != ''), function ($query) use ($search) {
                    $query->where("jahai_term", "LIKE", "%{$search}%")
                        ->orWhere("malay_term", "LIKE", "%{$search}%")
                        ->orWhere("english_term", "LIKE", "%{$search}%");
                })
                ->where(function ($query) {
                    $query->whereNotNull("jahai_term")
                        ->orWhereNotNull("malay_term");
                })
                ->orderBy("jahai_term")
                ->paginate(10);

            return response()->json($result, 200);
        } catch (\Throwable $th) {
            info($th->getMessage());
            $result = [
                'status'    => 500,
                'message'   => 'Failed'
            ];

            return response()->json($result, 500);
        }
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

    public function update(Request $request, $id)
    {
        $payload = $request->all();

        try {
            $term = Term::find($id);

            $term->update($payload);

            return response()->json($term, 200);
        } catch (\Throwable $th) {
            info($th->getMessage());
            $result = [
                'status'    => 500,
                'message'   => 'Failed'
            ];

            return response()->json($result, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $term = Term::find($id)->delete();

            if ($term) {

                return response()->json($term, 200);
            } else {

                $result = [
                    'status'    => 500,
                    'message'   => 'Failed'
                ];
                return response()->json($result, 500);
            }
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
            ->when($language == 'jahai', function ($q) use ($search) {
                $q->where("jahai_term", "LIKE", "%{$search}%");
            })
            ->when($language == 'malay', function ($q) use ($search) {
                $q->where("malay_term", "LIKE", "%{$search}%");
            })
            ->when($language == 'english', function ($q) use ($search) {
                $q->where("english_term", "LIKE", "%{$search}%");
            })
            ->paginate(5);

        return response()->json($result, 200);
    }
}
