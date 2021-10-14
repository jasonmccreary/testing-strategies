<?php

namespace JMac\TestingStrategies;

use JMac\TestingStrategies\Models\Order;

class PdfGenerator
{
    public function create()
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16);

        return $pdf;
    }

    public function createInvoice(Order $order): void
    {
        $pdf = $this->create();
        $pdf->Cell(40, 6, $order->item, 'TBL');
        $pdf->Cell(10, 6, $order->quantity, 'TBL');
        $pdf->Cell(25, 6, number_format($order->amount, 2), 'TBL', 0, 'R');
        $pdf->Cell(25, 6, number_format($order->subtotal, 2), 'TRBL', 0, 'R');

        $pdf->Output('F', $order->id . '.pdf');
    }
}
