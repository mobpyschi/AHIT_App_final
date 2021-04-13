<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->where('model_id', Auth::user()->id)
                ->get(['id', 'title', 'start', 'end', 'className', 'description']);

            return response()->json($data);
        }

        return view('calendar');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $input = $request->all();
                $input['description'] = ($request->description)? $request->description : null;
                $input['model_id'] = Auth::user()->id;
                $event = Event::create($input);
                return response()->json($event);
                break;

            case 'update':
                $input = $request->all();
                $input['description'] = ($request->description)? $request->description : null;
                $eventss = Event::find($input['id'])->update($input);
                $event = Event::find($input['id']);
                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();
                return response()->json($event);
                break;

            default:
                console('toang roi ong giao oi');
                break;
        }
    }
}
