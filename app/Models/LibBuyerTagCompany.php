<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibBuyerTagCompany extends Model
{
    use HasFactory;
    protected $table = 'lib_buyer_tag_company';
    protected $fillable = [
        'buyer_id','company_id'
    ];
}
