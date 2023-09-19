<?php

namespace App\Repositories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;


class QuizzRepository
{
    public function addNewQuestion($questionData)
    {

        $existingQuestion = Question::find($questionData->id);

        if (!$existingQuestion) {

            $questionToSave = new Question([
                '_id' => $questionData->id,
                'category' => $questionData->category,
                'correctAnswer' => $questionData->correctAnswer,
                'incorrectAnswers' => $questionData->incorrectAnswers,
                'question' => $questionData->question,
                'tags' => $questionData->tags,
                'type' => $questionData->type,
                'difficulty' => $questionData->difficulty,
                'regions' => $questionData->regions,
                'isNiche' => $questionData->isNiche,
            ]);

            $questionToSave->save();
        }
    }


    public function getAllQuestions(): Collection
    {
        return Question::all();
    }

    public function getQuestionsByCategory(string $category): Collection
    {
        return Question::where('category', $category)->get();
    }

    public function getQuestionsByTag(string $tag): Collection
    {
        return Question::where('tags', $tag)->get();
    }

}
