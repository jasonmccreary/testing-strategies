<?php

namespace JMac\TestingStrategies;

class PdfGenerator
{
    public function create()
    {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 16);

        return $pdf;
    }
}
