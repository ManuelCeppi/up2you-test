<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\InsertAttendeeRequest;
use App\Http\Request\UpdateAttendeeRequest;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventAttendee;
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

    public function register(int $attendeeId, int $eventId): Response
    {
        // Get event
        $event = Event::findOrFail($eventId);
        // Get attendee
        $attendee = Attendee::findOrFail($attendeeId);
        // Get event attendees
        $attendeesToEvent = EventAttendee::where(
            'event_id',
            $eventId
        )->count();

        // Check if the event is full
        if ($attendeesToEvent <= $event->max_attendees) {
            // Add attendee to event
            $eventAttendee = new EventAttendee();
            $eventAttendee->event_id = $eventId;
            $eventAttendee->attendee_id = $attendeeId;
            $eventAttendee->save();
        } else {
            return response(['message' => 'Event is full'], 400);
        }
        return response(['registered' => true], 200);
    }
}