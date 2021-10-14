<?php

namespace JMac\TestingStrategies;

use JMac\TestingStrategies\Models\Order;

class InvoiceGenerator
{
    private $pdfGenerator;

    public function __construct($pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function generate(\mysqli $mysqli)
    {
        $result = $mysqli->query('SELECT * FROM orders WHERE complete = 1', MYSQLI_USE_RESULT);
        while ($order = $result->fetch_object(Order::class)) {
            $this->pdfGenerator->createInvoice($order);
        }
    }
}
