<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $owners = Owner::all();
        return view('ownersIndex', compact('owners'));
    }

    public function show($owner_id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $owner = Owner::findOrFail($owner_id);
        return view('ownersShow', compact('owner'));
    }


    public function edit(Owner $owner): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('ownersEdit', compact('owner'));
    }

    public function update(Request $request, Owner $owner): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:50',
            'house_name' => 'nullable|string',
            'apartment_number' => 'nullable|string',
            'area_of_the_apartment' => 'nullable|numeric',
            'ownership_percentage' => 'nullable|numeric|between:0,100',
        ]);

        $owner->update($validated);

        return redirect()->route('owners.show', $owner->id)->with('success', 'Owner updated successfully.');
    }

}
