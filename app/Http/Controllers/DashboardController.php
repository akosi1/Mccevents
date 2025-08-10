<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('joins')
                     ->where('status', 'active')
                     ->upcoming();

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->orderBy('date', 'asc')->paginate(12);

        // Add is_joined attribute for each event
        $events->getCollection()->transform(function ($event) {
            $event->is_joined = $event->isJoinedByUser(auth()->id());
            return $event;
        });

        return view('dashboard', compact('events'));
    }
}