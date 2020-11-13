<?php
namespace App\Interfaces;

interface EnumContract
{
    public static function getList();
    public static function getArray();
    public static function getString($value);
}
