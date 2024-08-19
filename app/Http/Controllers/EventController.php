<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Exception;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::all();
            return $this->successResponse($events, 'Events fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $event = Event::create($request->validated());
            return $this->successResponse($event, 'Event created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function show(Event $event)
    {
        try {
            return $this->successResponse($event, 'Event fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        try {
            $event->update($request->validated());
            return $this->successResponse($event, 'Event updated successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return $this->successResponse(null, 'Event deleted successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
