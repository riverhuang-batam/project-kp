<?php
namespace App\Helpers;

class PaymentType
{
  const stock = 1;
  const shipping = 2;

  public static function getList()
  {
    return [
      self::stock,
      self::shipping
    ];
  }

  public static function getString($val)
  {
    switch($val)
    {
      case self::stock:
        return "Stock";
      case self::shipping:
        return "Shipping";
    }
  }
}