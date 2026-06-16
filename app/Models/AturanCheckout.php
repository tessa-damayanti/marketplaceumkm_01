<?php

namespace App\Models;

use Illuminate\Http\Request;

interface AturanCheckout
{
    /**
     * Kumpulkan data item untuk checkout.
     * Mengembalikan array item, atau array error jika gagal.
     *
     * @param Request $request
     * @param int $userId
     * @return array
     */
    public function collectItems(Request $request, int $userId): array;
}
