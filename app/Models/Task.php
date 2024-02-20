<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\TaskCreatedEvent;

class Task extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => TaskCreatedEvent::class,
    ];

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'completed'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
