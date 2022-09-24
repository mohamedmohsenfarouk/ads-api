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
        return $this->belongsToMany(Tag::class, 'tags_ads');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function getCategoryName($id)
    {
        return Category::whereId($id)->first()->name;
    }

    public function getAdvertiserName($id)
    {
        return Advertiser::whereId($id)->first()->name;
    }

    public function getAdvertiserEmail($id)
    {
        return Advertiser::whereId($id)->first()->email;
    }

    public function getTag($id)
    {
        $ads_tags = Ad::with('tags')->whereId($id)->first();
        $tags = $ads_tags->tags;
        $all_tags = [];
        foreach ($tags as $tag) {
            array_push($all_tags, $tag->name);
        }
        return $all_tags;
    }
}
