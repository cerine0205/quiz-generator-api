<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class QuizController extends Controller
{
    // POST /api/chats/{id}/generate
    public function generate(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $chat = $request->user()
            ->chats()
            ->findOrFail($id);

        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'user',
            'type' => 'text',
            'content' => ['text' => $request->topic],
        ]);

        $quiz = $this->generateQuizFromAI($request->topic);

        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'ai',
            'type' => 'quiz',
            'content' => $quiz,
        ]);

        return response()->json($quiz);
    }

    // POST /api/guest/generate
    public function generateGuest(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $quiz = $this->generateQuizFromAI($request->topic);

        return response()->json($quiz);
    }

    // POST /api/plan
    public function generatePlan(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|max:50',
        ]);

        $topic = $request->topic;
        $level = $request->level;

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4.1-nano',
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '
Return ONLY valid JSON.

The JSON must contain:
- level
- plan

The plan must be an array of exactly 7 days.

Each day must include:
- day
- task
- resource

Do not include explanations.
'
                ],
                [
                    'role' => 'user',
                    'content' => "
Create a 7-day learning plan.

Skill: {$topic}
Level: {$level}
"
                ],
            ],
        ]);

        $content = $response['choices'][0]['message']['content'];

        $plan = json_decode($content, true);

        if (!$plan) {
            return response()->json([
                'error' => 'Invalid AI response',
                'raw_response' => $content,
            ], 500);
        }

        return response()->json($plan);
    }

    private function generateQuizFromAI(string $topic): array
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4.1-nano',
            'response_format' => ['type' => 'json_object'],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '
Return ONLY valid JSON.

The JSON must contain:
- title
- questions

Each question must include:
- type
- question
- options
- correct_answer

Allowed question types:
- mcq: must have exactly 4 options
- TF: must have exactly these options: ["True", "False"]

Use EXACTLY:
"type": "mcq"
or
"type": "TF"

Do not include explanations.
'
                ],
                [
                    'role' => 'user',
                    'content' => "Create a short quiz with 5 questions about: {$topic}. Mix mcq and TF questions."
                ],
            ],
        ]);

        $content = $response['choices'][0]['message']['content'];

        $quiz = json_decode($content, true);

        if (!$quiz) {
            abort(response()->json([
                'error' => 'Invalid AI response',
                'raw_response' => $content,
            ], 500));
        }

        return $quiz;
    }
}