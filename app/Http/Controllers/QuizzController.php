<?php

namespace App\Http\Controllers;

use App\QuizzClient\QuizzClient;
use Illuminate\Http\Request;

class QuizzController extends Controller
{


    public function index()
    {
        $quizzClient = new QuizzClient();

        return $quizzClient->getRandomQuestions();
    }
}
