<?php

namespace JMac\TestingStrategies;

use JMac\TestingStrategies\Models\Order;

class InvoiceGenerator
{
    public function generate()
    {
        $mysqli = new \mysqli(
            'localhost',
            'my_user',
            'my_password',
            'application'
        );

        $result = $mysqli->query('SELECT * FROM orders WHERE complete = 1', MYSQLI_USE_RESULT);
        while ($order = $result->fetch_object(Order::class)) {
            file_put_contents($order->id . '.pdf', $this->createInvoice($order));
        }
    }

    private function createInvoice(Order $order): string
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(40, 6, $order->item, 'TBL');
        $pdf->Cell(10, 6, $order->quantity, 'TBL');
        $pdf->Cell(25, 6, number_format($order->amount), 'TBL', 0, 'R');
        $pdf->Cell(25, 6, number_format($order->subtotal), 'TRBL', 0, 'R');

        return $pdf->Output('S');
    }
}
