<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;


class Question extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'questions';

    protected $fillable = [
        '_id',
        'category',
        'correctAnswer',
        'incorrectAnswers',
        'question',
        'tags',
        'type',
        'difficulty',
        'regions',
        'isNiche',
    ];


}
