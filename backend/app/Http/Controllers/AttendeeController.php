<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\InsertAttendeeRequest;
use App\Http\Request\UpdateAttendeeRequest;
use App\Models\Attendee;
use Illuminate\Http\Response;

class AttendeeController extends Controller
{
    public function get(int $attendeeId): Response
    {
        $attendee = Attendee::findOrFail($attendeeId);
        return response(['attendee' => $attendee], 200);
    }

    public function getAll(): Response
    {
        $attendees = Attendee::all();
        return response(['attendees' => $attendees], 200);
    }

    public function insert(InsertAttendeeRequest $insertAttendeeRequest): Response
    {
        $attendee = new Attendee();
        $attendee->fill($insertAttendeeRequest->validated());
        $attendee->save();
        return response(['attendee' => $attendee], 201);
    }

    public function update(int $attendeeId, UpdateAttendeeRequest $updateAttendeeRequest): Response
    {
        $attendee = Attendee::findOrFail($attendeeId);
        $attendee->fill($updateAttendeeRequest->validated());
        $attendee->save();
        return response(['attendee' => $attendee], 200);
    }

    public function delete(int $attendeeId): Response
    {
        $attendee = Attendee::findOrFail($attendeeId);
        $attendee->delete();
        return response([], 204);
    }
}