<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function init(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'feature' => 'required|string',
            'reference' => 'required|string',
            'status' => 'required|string',
            'paymentLink' => 'required|string',
        ]);

        // ✅ Create a pending purchase record
        $purchase = Purchase::create($data);

        return response()->json([
            'status' => 'pending',
            'reference' => $purchase->reference,
            'payment_link' => $purchase->paymentLink,
        ]);
    }
}
