<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\QuizzClient\QuizzClient;
use DB;
use Illuminate\Http\Request;

class QuizzController extends Controller
{


    public function index()
    {
        $quizzClient = new QuizzClient();

        $questions = $quizzClient->getRandomQuestions();

        foreach ($questions as $questionData) {
            $id = $questionData->id;

            // Check if a question with the same ID already exists
            $existingQuestion = Question::find($id);

            if (!$existingQuestion) {
                // Create a new Question instance based on the data
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

        return $questions;
    }


    public function dev()
    {
        // $r = DB::connection('mongodb')->collection('migrations')->get();
        // $r = DB::connection('mongodb')->collection('questions')->insert(['teste']);
        $quizzClient = new QuizzClient();
        $questions =  $quizzClient->getRandomQuestions();
        dd($questions);
    }
}
