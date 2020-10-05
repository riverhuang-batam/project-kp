<?php

namespace App\Helpers;

class OrderStatus
{
  const waiting = 1;
  const shippingToWarehouse  = 2;
  const shippingToIndonesia  = 3;
  const arrived = 4;
  const completed = 5;

  public static function getList()
  {
    return [
      self::waiting,
      self::shippingToWarehouse,
      self::shippingToIndonesia,
      self::arrived,
      self::completed,
    ];
  }

  public static function getString($val)
  {
    switch ($val) {
      case self::waiting:
        return "Waiting"; // for pre-order system
      case self::shippingToWarehouse:
        return "Shipping to Warehouse";
      case self::shippingToIndonesia:
        return "Shipping to Indonesia";
      case self::arrived:
        return "Arrived";
      case self::completed:
        return "Completed";
    }
  }
}