<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Services\HouseService;
use App\Services\MeetingService;
use App\Services\VoteService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private HouseService $houseService;
    private MeetingService $meetingService;
    private VoteService $voteService;

    public function __construct(HouseService $houseService, MeetingService $meetingService, VoteService $voteService)
    {
        $this->houseService = $houseService;
        $this->meetingService = $meetingService;
        $this->voteService = $voteService;
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('adminPanel');
    }


    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('createHouses');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'house_name' => 'required|string|max:255',
            'start_apartment' => 'required|integer',
            'end_apartment' => 'required|integer|gt:start_apartment',
        ]);

        $house = $this->houseService->createHouseWithFlats(
            $request->input('house_name'),
            $request->input('start_apartment'),
            $request->input('end_apartment')
        );

        // Перенаправление на страницу с созданным домом или показ сообщения об успешной операции
        return redirect()->route('admin')->with('success', 'Дом создан успешно!');
    }

    public function createMeeting(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $houses = House::all();
        return view('createMeeting', compact('houses'));
    }

    public function storeMeeting(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'house_name' => 'required|string',
            'date' => 'required|date',
            'question' => 'required|string',
        ]);

        $meeting = $this->meetingService->createMeeting(
            $request->input('house_name'),
            $request->input('date'),
            $request->input('question')
        );

        return redirect()->route('admin')->with('success', 'Meeting created successfully!');
    }
}
//
//    public function showVotes(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
//    {
//        $houses = $this->voteService->getAllHouses();
//        return view('showVotes', compact('houses'));
//    }
//
//    public function getMeetings(Request $request): \Illuminate\Http\JsonResponse
//    {
//        // Получаем ID дома из запроса
//        $houseId = $request->input('house_id');
//
//        // Получаем собрания для дома
//        $meetings = $this->voteService->getMeetingsForHouse($houseId);
//
//        // Возвращаем JSON с meeting_id и датами собраний
//        return response()->json($meetings);
//    }
//
//    public function getVotes(Request $request): \Illuminate\Http\JsonResponse
//    {
//        // Получаем ID собрания из запроса
//        $meetingId = $request->input('meeting_id');
//
//        // Получаем данные о голосах по ID собрания
//        $votesData = $this->voteService->getVotesByMeeting($meetingId);
//
//        // Возвращаем JSON с результатами голосования
//        return response()->json($votesData);
//    }
//
//}
