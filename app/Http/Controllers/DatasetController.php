<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatasetController extends Controller
{
    public function filter(Request $request)
    {

        $this->incrementUserQuery();

        $code = $request->input('code');
        $name = $request->input('name');
        $description = $request->input('description');
        $amount = $request->input('amount');

        $query = Dataset::query();

        if ($code) {
            $query->where('code', 'LIKE', "%{$code}%");
        }

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($description) {
            $query->where('description', 'LIKE', "%{$description}%");
        }

        if ($amount) {
            $query->where('amount', $amount);
        }

        $results = $query->get();

        return response()->json($results);
    }


    public function dashboard(Request $request)
    {

        $this->incrementUserQuery();

        $code = $request->input('code');
        $name = $request->input('name');
        $description = $request->input('description');
        $amount = $request->input('amount');

        $query = Dataset::query();

        if ($code) {
            $query->where('code', 'LIKE', "%{$code}%");
        }

        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($description) {
            $query->where('description', 'LIKE', "%{$description}%");
        }

        if ($amount) {
            $query->where('amount', $amount);
        }

        $data = [
            'total_entries' => $query->count(),
            'amount_distribution' => $query->selectRaw('amount, COUNT(*) as count')
                ->groupBy('amount')
                ->get(),
            'top_names' => $query->selectRaw('id, name, amount, COUNT(*) as count')
                ->groupBy('id', 'name', 'amount')
                ->orderBy('count', 'DESC')
                ->take(5)
                ->get(),
        ];

        return response()->json($data);
    }


    public function details($id)
    {
        $this->incrementUserQuery();

        $data = Dataset::find($id);

        if (!$data) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json($data);
    }

    
    private function incrementUserQuery()
    {
        $user = Auth::user();

        $userQuery = UserQuery::firstOrCreate(
            ['user_id' => $user->id],
            ['query_count' => 0]
        );

        $userQuery->increment('query_count');
    }
}
