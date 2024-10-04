<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{

    /**
     * Get paginated events.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $payload = $request->all();
            $per_page =  $payload['per_page'] ?? 5;
            Log::info($payload);
            $events = Event::paginate($per_page);
            return $this->successResponse($events, 'Events fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        try {
            $event = Event::create($request->validated());
            return $this->successResponse($event, 'Event created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        try {
            return $this->successResponse($event, 'Event fetched successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request)
    {
        try {
            $id = $request->route('event');
            $event = Event::findOrFail($id);
            $event->update($request->validated());

            return $this->successResponse($event, 'Event updated successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->route('event');
            $event = Event::find($id);
            if (!$event) {
                return $this->errorResponse(null, 'Event not found', 404);
            }

            $event->delete();

            return $this->successResponse(null, 'Event deleted successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
