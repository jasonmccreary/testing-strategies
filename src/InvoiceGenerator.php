<?php

namespace JMac\TestingStrategies;

class InvoiceGenerator
{
    private $pdfGenerator;
    private $invoiceRepository;

    public function __construct($pdfGenerator, $orderRepository)
    {
        $this->pdfGenerator = $pdfGenerator;
        $this->invoiceRepository = $orderRepository;
    }

    public function generate()
    {
        $orders = $this->invoiceRepository->completed();
        foreach ($orders as $order) {
            $this->pdfGenerator->createInvoice($order);
        }
    }
}
