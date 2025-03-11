<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    //

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'question' => [
                'required',
                'string',
                'min:10',
                new EndWithQuestionMarkRule(),
            ],
        ]);

        Question::query()->create($data);

        return redirect()->route('dashboard');
    }
}
