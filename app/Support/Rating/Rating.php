<?php

namespace App\Support\Rating;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'rating',
        'ratingable_id',
        'ratingable_type',
        'author_id',
        'author_type',
    ];

    public function ratingable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->morphTo('author');
    }

    public function createRating(Model $ratingable, array $data, Model $author)
    {
        $rating = new static();
        $rating->fill(array_merge($data, [
            'author_id' => $author->getKey(),
            'author_type' => get_class($author),
        ]));

        $ratingable->ratings()->save($rating);

        return $rating;
    }

    public function createUniqueRating(Model $ratingable, array $data, Model $author)
    {
        return static::updateOrCreate([
            'author_id' => $author->getKey(),
            'author_type' => get_class($author),
            'ratingable_id' => $ratingable->getKey(),
            'ratingable_type' => get_class($ratingable),
        ], $data);
    }

    public function updateRating($id, array $data)
    {
        $rating = static::findOrFail($id);
        $rating->update($data);

        return $rating;
    }

    public function deleteRating($id)
    {
        return static::findOrFail($id)->delete();
    }
}
