<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listModel extends Model
{
    use HasFactory;

    protected $table =  'list';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'description', 'deadline', 'completed'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(statusModel::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(categoryModel::class, 'category_id');
    }

}
