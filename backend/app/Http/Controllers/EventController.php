<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\InsertEventRequest;
use App\Http\Request\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Response;

class EventController extends Controller
{

    public function __construct() {}

    public function get(int $eventId): Response
    {
        $event = Event::find($eventId);
        return response(['event' => $event], 200);
    }

    public function getAll(): Response
    {
        $events = Event::all();
        return response(['events' => $events], 200);
    }

    public function insert(InsertEventRequest $insertEventRequest): Response
    {
        $event  = new Event();
        $event->fill($insertEventRequest->validated());
        $event->save();
        return response(['event' => $event], 201);
    }

    public function update(int $eventId, UpdateEventRequest $updateEventRequest): Response
    {
        $event = Event::findOrFail($eventId);
        $event->fill($updateEventRequest->validated());
        $event->save();
        return response(['event' => $event], 200);
    }

    public function delete(int $eventId): Response
    {
        $event = Event::findOrFail($eventId);
        $event->delete();
        return response([], 204);
    }
}