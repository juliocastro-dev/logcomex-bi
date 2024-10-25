<?php

namespace App\Http\Controllers;

use App\Models\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQueryController extends Controller
{

   public function getQueryCount()
   {

       $user = Auth::user();

       $userQuery = UserQuery::where('user_id', $user->id)->first();

       if (!$userQuery) {
           return response()->json(['query_count' => 0]);
       }

       return response()->json(['query_count' => $userQuery->query_count]);
   }


   public function listAllQueryCounts()
   {

       $allQueries = UserQuery::with('user:id,name,email')->get();

       return response()->json($allQueries);
   }


   public function resetQueryCount($userId)
   {

       $userQuery = UserQuery::where('user_id', $userId)->first();

       if (!$userQuery) {
           return response()->json(['message' => 'User not found'], 404);
       }

       $userQuery->query_count = 0;
       $userQuery->save();

       return response()->json(['message' => 'Query count reset successfully']);
   }
}
