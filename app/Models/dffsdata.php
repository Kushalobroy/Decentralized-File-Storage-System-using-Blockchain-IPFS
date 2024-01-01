<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dffsdata extends Model
{
    use HasFactory;
    protected $fillable = ['ipfsHash', 'userId'];
}
