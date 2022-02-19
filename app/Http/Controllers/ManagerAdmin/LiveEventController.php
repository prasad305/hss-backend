<?php

namespace App\Http\Controllers\ManagerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveChat;
use Carbon\Carbon;
use App\Models\Category;

class LiveEventController extends Controller
{
    /**
     * upcomming events
     */
    public function UpcommingEvent()
    {

        $upcommingEvent = LiveChat::whereDate('date', '<=', Carbon::now()->format('Y-m-d'))->take(6)->get();
        return view('ManagerAdmin.UpCommingEvents.index', compact('upcommingEvent'));
    }

    /**
     * events details
     */
    public function detailsEvent($id, $categoryId = null)
    {
        $categoryId = $categoryId;
        $eventsDetails = LiveChat::findOrfail($id);
        return view('ManagerAdmin.DetailsEvent.index', compact('eventsDetails', 'categoryId'));
    }

    /**
     * events approved
     */
    public function approvedEvent($id, $categoryId)
    {
        // dd($categoryId);
        $approvedEvent = LiveChat::findOrfail($id);
        $approvedEvent->publish_status = 1;
        $approvedEvent->save();

        if ($categoryId != "null") {
            return redirect()->route('managerAdmin.events', $categoryId)->with('success', 'publish successfull');
        } else {
            return redirect()->route('managerAdmin.UpcommingEvent')->with('success', 'publish successfull');
        }
    }

    /**
     * all events
     */
    public function categorys()
    {
        $allCategory = Category::orderBy('id', 'DESC')->get();
        return view('ManagerAdmin.allEventsCtegory.index', compact('allCategory'));
    }

    /**
     * show event base on category
     */
    public function events($id)
    {
        $categoryId = $id;
        $category = Category::find($id);
        $events = $category->liveEvents;

        return view('managerAdmin.EventsbyCategory.index', compact('events', 'category', 'categoryId'));
    }
}
