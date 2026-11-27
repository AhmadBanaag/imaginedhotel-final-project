<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('roomType')->get();
        $roomTypes = RoomType::all();
        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'room_number'  => 'required|string|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,room_type_id',
            'status'       => 'required|in:available,booked,unavailable'
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'New Room Unit Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number'  => 'required|string|unique:rooms,room_number,' . $id . ',room_id',
            'room_type_id' => 'required|exists:room_types,room_type_id',
            'status'       => 'required|in:available,booked,unavailable'
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Room::destroy($id);
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}