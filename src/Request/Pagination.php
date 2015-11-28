<?php

namespace RCatlin\Blog\Request;

class Pagination
{
    const ORDER_DESCENDING = 'DESC';
    const ORDER_ASCENDING = 'ASC';

    /**
     * @var array
     */
    public static $orders = [
        self::ORDER_DESCENDING,
        self::ORDER_ASCENDING,
    ];

    /**
     * @param $val
     *
     * @return bool
     */
    public static function inOrders($val)
    {
        return in_array($val, self::$orders);
    }
}
