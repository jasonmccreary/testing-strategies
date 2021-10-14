<?php

namespace JMac\TestingStrategies;

use JMac\TestingStrategies\Models\Order;

class OrderRepository
{
    /**
     * @return array<Order>
     */
    public function completed(): array
    {
        $orders = [];
        $result = $this->db->query('SELECT * FROM orders WHERE complete = 1', MYSQLI_USE_RESULT);
        while ($order = $result->fetch_object(Order::class)) {
            $orders[] = $order;
        }

        return $orders;
    }
}
