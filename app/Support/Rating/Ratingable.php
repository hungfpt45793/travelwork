<?php

namespace App\Support\Rating;

use Illuminate\Database\Eloquent\Model;

trait Ratingable
{
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function avgRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    public function countPositive()
    {
        return $this->ratings()->where('rating', '>', 0)->count();
    }

    public function countNegative()
    {
        return '-'.$this->ratings()->where('rating', '<', 0)->count();
    }

    public function rating(array $data, Model $author, ?Model $parent = null)
    {
        return (new Rating())->createRating($this, $data, $author);
    }

    public function ratingUnique(array $data, Model $author, ?Model $parent = null)
    {
        return (new Rating())->createUniqueRating($this, $data, $author);
    }

    public function updateRating($id, array $data, ?Model $parent = null)
    {
        return (new Rating())->updateRating($id, $data);
    }

    public function deleteRating($id)
    {
        return (new Rating())->deleteRating($id);
    }

    public function getAvgRatingAttribute()
    {
        return $this->avgRating();
    }

    public function getRatingPercentAttribute()
    {
        return $this->ratingPercent();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getCountPositiveAttribute()
    {
        return $this->countPositive();
    }

    public function getCountNegativeAttribute()
    {
        return $this->countNegative();
    }
}
