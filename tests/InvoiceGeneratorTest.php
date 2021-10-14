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
        $order1 = new Order();
        $order2 = new Order();

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
