<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\QuizzClient\QuizzClient;
use App\Repositories\QuizzRepository;
use DB;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    protected QuizzRepository $quizzRepository;

    public function __construct(QuizzRepository $quizzRepository)
    {
        $this->quizzRepository = $quizzRepository;
    }


    public function index(): array
    {
        $quizzClient = new QuizzClient();

        $questions = $quizzClient->getRandomQuestions();

        foreach ($questions as $questionData) {
            $this->quizzRepository->addNewQuestion($questionData);
        }

        return ['total' => count($questions), 'data' => $questions];
    }

    public function getAllQuestions(): array
    {
        $questions = $this->quizzRepository->getAllQuestions();
        return ['total' => count($questions), 'data' => $questions];
    }

    public function getQuestionsByCategory(Request $request): array
    {
        $questions = $this->quizzRepository->getQuestionsByCategory($request->category);
        return ['total' => count($questions), 'data' => $questions];
    }

    public function getQuestionsByTag(Request $request)
    {
        $questions = $this->quizzRepository->getQuestionsByTag($request->tag);
        return ['total' => count($questions),'data' => $questions];
    }


    public function getFilteredQuestions(Request $request)
    {
        $category = $request->query('category');
        $tag = $request->query('tag');

        if ($category && $tag) {
            $questionsCategory = $this->quizzRepository->getQuestionsByCategory($category);
            $questionsTag = $this->quizzRepository->getQuestionsByTag($tag);
            $questions = $questionsCategory->merge($questionsTag);
        } elseif ($category) {
            $questions = $this->quizzRepository->getQuestionsByCategory($category);
        } elseif ($tag) {
            $questions = $this->quizzRepository->getQuestionsByTag($tag);
        } else {
            $questions = [];
        }

        return ['total' => count($questions), 'data' => $questions];
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
