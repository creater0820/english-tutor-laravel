<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Contract;
use Carbon\Carbon;


class ContractController extends Controller
{
    public function new()
    {
        $now = new Carbon();
        $timeLine =  Contract::where('created_at', '>=', $now->subDays(30)->format('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->get();
        return response()->json([
            'timeLine' => $timeLine,
        ], 200);
    }
}
