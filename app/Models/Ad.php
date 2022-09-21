<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'title',
        'description',
        'category',
        'advertiser',
        'start_date',
    ];

    public function advertiser()
    {
        return $this->hasOne(Advertiser::class, 'id', 'advertiser');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id', 'category');
    }
}
