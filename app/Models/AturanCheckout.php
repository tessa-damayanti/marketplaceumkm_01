<?php

namespace App\Models;

use Illuminate\Http\Request;

interface AturanCheckout
{
    /**
     * Kumpulkan data item untuk checkout.
     * @param Request $request
     * @param int $userId
     * @return array
     */
    public function collectItems(Request $request, int $userId): array;
}
