<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\House;
use App\Models\Meeting;
use App\Models\Question;

class MeetingService
{
    public function createMeeting($houseName, $date, $questions)
    {
        $house = House::where('house_name', $houseName)->firstOrFail();

        $meeting = Meeting::create([
            'house_id_for_meetings' => $house->house_id,
            'date' => $date,
        ]);

        foreach ($questions as $questionData) {
            $question = Question::create([
                'meeting_id_for_question' => $meeting->meeting_id,
                'question' => $questionData['text'],
            ]);

            foreach ($questionData['answers'] as $answerText) {
                Answer::create([
                    'question_id_for_answers' => $question->question_id,
                    'answer_text' => $answerText,
                ]);
            }
        }

        return $meeting;
    }
}

