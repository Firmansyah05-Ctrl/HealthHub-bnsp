<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generateInvoice(Order $order)
    {
        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        return $pdf->download('invoice-'.$order->id.'.pdf');
    }
}