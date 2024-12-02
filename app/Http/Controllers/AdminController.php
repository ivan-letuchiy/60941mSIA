<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\House;
use App\Models\Meeting;
use App\Models\Question;
use App\Services\HouseService;
use App\Services\MeetingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private HouseService $houseService;
    private MeetingService $meetingService;

    public function __construct(HouseService $houseService, MeetingService $meetingService)
    {
        $this->houseService = $houseService;
        $this->meetingService = $meetingService;
    }

    public function index(): View
    {
        return view('adminPanel');
    }

    public function create(): View
    {
        return view('createHouses');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'house_name' => 'required|string|max:255|unique:houses,house_name',
            'start_apartment' => 'required|integer|min:1',
            'end_apartment' => 'required|integer|gt:start_apartment',
        ]);

        $this->houseService->createHouseWithFlats($validated['house_name'], $validated['start_apartment'], $validated['end_apartment']);
        return redirect()->route('admin.panel')->with('success', 'Дом создан успешно!');
    }

    public function createMeeting(): View
    {
        $houses = House::all();
        return view('createMeeting', compact('houses'));
    }

    public function storeMeeting(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,house_id',
            'date' => 'required|date',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.answers' => 'required|array|min:1',
            'questions.*.answers.*' => 'required|string',
        ]);

        // Создание собрания
        $meeting = Meeting::create([
            'house_id_for_meetings' => $validated['house_id'],
            'date' => $validated['date'],
        ]);

        // Проверка, создано ли собрание
        if (!$meeting) {
            return redirect()->back()->withErrors('Ошибка создания собрания.');
        }

        // Сохранение вопросов и ответов
        foreach ($validated['questions'] as $questionData) {
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

        return redirect()->route('admin.panel')->with('success', 'Собрание создано успешно!');
    }

}
