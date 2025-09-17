<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gemini;

class GeminiController extends Controller
{
    protected $gemini;

    public function __construct(Gemini $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $response = $this->gemini->generateText($request->prompt);

        return response()->json([
            'prompt' => $request->prompt,
            'response' => $response,
        ]);
    }
}
