<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    //

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'question' => 'required|string|min:10',
        ]);

        Question::query()->create($data);

        return redirect()->route('dashboard');
    }
}
