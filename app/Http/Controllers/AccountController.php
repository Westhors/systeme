<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with(['children' => function($query) {
            $query->orderBy('code');
        }])
        ->get();

        return AccountResource::collection($accounts);
    }


    public function show($code)
    {
        $account = Account::with(['parent', 'children' => function($query) {
            $query->orderBy('code');
        }])
        ->where('code', $code)
        ->firstOrFail();

        return new AccountResource($account);
    }
}
