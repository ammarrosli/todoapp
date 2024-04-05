<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusModel extends Model
{
    use HasFactory;
    protected $table =  'status';
    protected $primaryKey = 'id';
    protected $fillable = ['Sname'];
}
