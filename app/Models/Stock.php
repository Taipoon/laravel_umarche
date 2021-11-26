<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // テーブル名を t_stock (トランザクション用テーブル) に変更
    protected $table = 't_stocks';
}
