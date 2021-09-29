<?php

namespace JMac\TestingStrategies;

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
        while ($order = $result->fetch_assoc()) {
            file_put_contents($order['id'] . '.pdf', $this->createInvoice($order));
        }
    }

    private function createInvoice(array $order): string
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',16);
        $pdf->Cell(40,6,$order['item'],'LR');
        $pdf->Cell(10,6,$order['quantity'],'LR');
        $pdf->Cell(25,6,number_format($order['amount']),'LR',0,'R');
        $pdf->Cell(25,6,number_format($order['subtotal']),'LR',0,'R');
        $pdf->Ln();
        $pdf->Cell(100,0,'','T');
        $pdf->Output();
    }
}
