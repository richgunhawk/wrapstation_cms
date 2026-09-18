<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $allowedFields = ['user_id', 'product_id', 'payment_method', 'qty', 'total_price'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
}
