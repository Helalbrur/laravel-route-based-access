<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibBuyerTagParty extends Model
{
    use HasFactory;
    protected $table = 'lib_buyer_tag_parties';
    protected $fillable = [
        'buyer_id','party_type'
    ];
}
