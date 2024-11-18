<?php

namespace App\Services;

use App\Models\House;
use App\Models\Meeting;

class VoteService
{
    public function getAllHouses(): \Illuminate\Database\Eloquent\Collection
    {
        // Получаем все дома
        return House::all();
    }

    public function getMeetingsForHouse(int $houseId): \Illuminate\Support\Collection
    {
        // Возвращаем собрания с их meeting_id и датой для конкретного дома
        return Meeting::where('house_id_for_meetings', $houseId)
            ->select('meeting_id', 'date')
            ->get();
    }

    public function getVotesByMeeting(int $meetingId): array
    {
        // Получаем собрание по его ID
        $meeting = Meeting::with('questions.votes.ownerVote.flatsM.house')
            ->find($meetingId);

        // Получаем первый вопрос (если требуется несколько вопросов, этот код нужно изменить)
        $question = $meeting->questions->first();

        // Если вопрос существует, обрабатываем голоса
        if ($question) {
            $votes = $question->votes;

            // Формируем массив с результатами
            $results = [
                'question' => $question->question_text, // Текст вопроса собрания
                'votes' => [],
            ];

            foreach ($votes as $vote) {
                $owner = $vote->ownerVote;
                $flat = $owner->flatsM->first(); // Берем первую квартиру собственника
                $house = $flat->house;

                $results['votes'][] = [
                    'owner_name' => $owner->full_name,
                    'flat_number' => $flat->apartment_number,
                    'house_name' => $house->house_name,
                    'answer' => $vote->answer,
                ];
            }

            return $results;
        }

        return [];
    }
}
