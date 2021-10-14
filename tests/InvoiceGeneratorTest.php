<?php

namespace Tests;

use JMac\TestingStrategies\InvoiceGenerator;
use JMac\TestingStrategies\Models\Order;
use JMac\TestingStrategies\OrderRepository;
use JMac\TestingStrategies\PdfGenerator;

class InvoiceGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $order1 = \Mockery::mock(Order::class);
        $order1->id = 123;
        $order1->item = 'Testing an item';
        $order1->quantity = 10;
        $order1->amount = 5.00;
        $order1->subtotal = 50.00;
        $order2 = \Mockery::mock(Order::class);
        $order2->id = 123;
        $order2->item = 'Testing an item';
        $order2->quantity = 10;
        $order2->amount = 5.00;
        $order2->subtotal = 50.00;

        $orderRepository = \Mockery::mock(OrderRepository::class);
        $orderRepository->expects('completed')
            ->withNoArgs()
            ->andReturn([$order1, $order2]);

        $pdfGenerator = \Mockery::mock(PdfGenerator::class);
        $pdfGenerator->expects('createInvoice')
            ->with($order1);
        $pdfGenerator->expects('createInvoice')
            ->with($order2);

        $subject = new InvoiceGenerator($pdfGenerator, $orderRepository);
        $subject->generate();
    }
}
