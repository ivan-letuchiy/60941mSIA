<?php

namespace App\Services;

use App\Models\House;
use App\Models\Meeting;
use App\Models\Question;

class MeetingService
{
    public function createMeeting($houseName, $date, $question)
    {
        // Находим дом по названию
        $house = House::where('house_name', $houseName)->firstOrFail();

        // Создаем встречу, используя найденный ID дома
        $meeting = Meeting::create([
            'house_id_for_meetings' => $house->house_id,
            'date' => $date,
        ]);

        Question::create([
            'meeting_id_for_question' => $meeting->id,
            'question' => $question,
        ]);

        return $meeting;
    }

    public function getMeetingsByHouseAndDate($houseId)
    {
        return Meeting::where('house_id_for_meetings', $houseId)->get();
    }
}
