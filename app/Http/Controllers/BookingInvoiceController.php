<?php

/**
 * Summary of namespace App\Http\Controllers\BookingInvoiceController
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\CarBooking;
use Illuminate\Http\Request;

class BookingInvoiceController extends Controller
{
    /**
     * Summary of index
     * @param mixed $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index($id)
    {
        $data = CarBooking::where('id', $id)
            ->orWhere('invoice_id', $id)
            ->with('user')
            ->firstOrFail();

        return view('admin.invoice.index', compact('data'));
    }
}