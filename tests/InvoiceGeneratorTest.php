<?php

namespace Tests;

use JMac\TestingStrategies\InvoiceGenerator;
use JMac\TestingStrategies\Models\Order;
use JMac\TestingStrategies\PdfGenerator;

class InvoiceGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $order = \Mockery::mock(Order::class);
        $order->id = 123;
        $order->item = 'Testing an item';
        $order->quantity = 10;
        $order->amount = 5.00;
        $order->subtotal = 50.00;

        $resultset = \Mockery::mock();
        $resultset->shouldReceive('fetch_object')
            ->with(Order::class)
            ->andReturn($order, false);
        $db = \Mockery::mock(\mysqli::class);
        $db->expects('query')
            ->with('SELECT * FROM orders WHERE complete = 1', MYSQLI_USE_RESULT)
            ->andReturn($resultset);

        $pdf = \Mockery::mock();
        $pdf->expects('Cell')
            ->with(40, 6, 'Testing an item', 'TBL');
        $pdf->expects('Cell')
            ->with(10, 6, 10, 'TBL');
        $pdf->expects('Cell')
            ->with(25, 6, '5.00', 'TBL', 0, 'R');
        $pdf->expects('Cell')
            ->with(25, 6, '50.00', 'TRBL', 0, 'R');
        $pdf->expects('Output')
            ->with('S')
            ->andReturn('the pdf output');

        $pdfGenerator = \Mockery::mock(PdfGenerator::class);
        $pdfGenerator->expects('create')
            ->andReturn($pdf);

        $subject = new InvoiceGenerator($pdfGenerator);
        $subject->generate($db);

        $this->assertStringEqualsFile('123.pdf', 'the pdf output');
    }
}
