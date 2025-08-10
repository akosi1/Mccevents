<?php

namespace App\Http\Controllers;

use App\Models\{Event, EventJoin, Notification};
use Illuminate\Http\Request;

class EventJoinController extends Controller
{
    public function join(Request $request, Event $event)
    {
        if ($event->isJoinedByUser(auth()->id())) {
            return response()->json([
                'success' => false,
                'message' => 'You have already joined this event.'
            ]);
        }

        EventJoin::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'joined_at' => now()
        ]);

        // Create notification for admin
        Notification::create([
            'type' => 'event_join',
            'message' => auth()->user()->full_name . ' joined "' . $event->title . '"',
            'data' => [
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'user_name' => auth()->user()->full_name,
                'event_title' => $event->title
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully joined the event!'
        ]);
    }

    public function leave(Request $request, Event $event)
    {
        $join = EventJoin::where('user_id', auth()->id())
                         ->where('event_id', $event->id)
                         ->first();

        if (!$join) {
            return response()->json([
                'success' => false,
                'message' => 'You have not joined this event.'
            ]);
        }

        $join->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully left the event!'
        ]);
    }
}