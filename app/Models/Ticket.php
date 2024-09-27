<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'issue_title',
        'description',
        'status',
        'feedback'
    ];


    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
