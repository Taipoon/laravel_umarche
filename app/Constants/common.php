<?php

namespace App\Constants;

class Common
{
  public const PRODUCT_ADD = '1';
  public const PRODUCT_REDUCE = '2';

  const PRODUCT_LIST = [
    'add' => self::PRODUCT_ADD,
    'reduce' => self::PRODUCT_REDUCE,
  ];
}
