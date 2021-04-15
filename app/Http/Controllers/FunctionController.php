<?php
namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\HistoryChecks;
use App\Models\User;
use Auth;
use Carbon;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;

class FunctionController extends Controller
{

    // check time to work and location of users
    /* BEGIN FUNCTION CHECKLOGIN*/
    public function logiCheckin(Request $request, $id)
    {

        //------User by name------
        $user = User::where('id', $request->id)->first();

        /**------GET DATA--------*/
        $getDay = explode(":", $request->date);

        $checkDay = date('d m Y');

        //---String Process---
        $ipAdress = $request->ip;

        /**------TIME DEFAUT OF DAY-----*/
        $config = Configuration::first();
        $timeStartCheckin = $config->timeStartCheckin;
        $timeEndCheckin = $config->timeEndCheckin;
        $ipDefaut = $config->ipDefaut;

        $input = $request->all();

        /** LOGIC CHECK */
        // $ngayDiLam = $user->workday;

        /**-----CHECK CONDITION----*/
        //------CHECK DAY OF MONTH------
        $dayNow = date('d');
        $monthNow = date('m');
        $dayOfWeek = date('l');

        /** RESET WORK */

        //-----LOCATION----
        if ($ipAdress == $ipDefaut) {
            //------CHECK TIME----
            if ($getDay[0] != "Sunday") {
                //---time : 8h -> 8h14p59s  ----
                $user->is_check = 1;

            } else {
                return redirect('/home')->with('status', 'Today is Sunday,goback in tomorrow');
            }
        } else {
            return redirect('/home')->with('status', 'loi ip hoac time ');
        }

        //id user check-in recrently
        $idHistoryMax = HistoryChecks::where('model_id', $user->id)->get()->max('id');
        //get history User to Save
        $historyUser = HistoryChecks::where('model_id', $user->id)->latest()->first();

        if (empty($historyUser)) {
            if ($user->save()) {
                //-------RETURN FUNCTION INDEX-----
                $history = HistoryChecks::create([
                    'model_id' => $id,
                    'checkin_time' => $input['time'],
                ]);
                return redirect('/')->with('status', 'Checked Success');
            }
            return redirect('/')->with('status', 'Checked Fail');
            //

        } else {
            $dateHistoty = date('d m Y', strtotime($historyUser->created_at));

            if ($checkDay != $dateHistoty) {
                if ($user->save()) {
                    //-------RETURN FUNCTION INDEX-----
                    $history = HistoryChecks::create([
                        'model_id' => $id,
                        'checkin_time' => $input['time'],
                    ]);
                    return redirect('/')->with('status', 'Checked Success');
                }
                return redirect('/')->with('status', 'Checked Fail');
            } else {
                return redirect('/')->with('status', 'You have checked!');
            }

        }

    } /* END FUNCTION */

    /* BEGIN FUNCTION CHECKLOGOUT*/
    public function logiCheckout(Request $request)
    {
        $input = $request->all();
        //------User by name------
        $user = User::where('id', Auth::user()->id)->first();
        /**------GET DATA--------*/
        $getDay = explode(":", $input['date']);

        //---String Process---
        $ipAdress = $request->ip;

        /**------TIME DEFAUT OF DAY-----*/
        $config = Configuration::first();
        $timeStartCheckout = $config->timeStartCheckout;
        $timeEndCheckout = $config->timeEndCheckout;
        $ipDefaut = $config->ipDefaut;

        /**-----CHECK CONDITION----*/

        //------Time work------

        //------CHECK DAY OF MONTH------
        $dayNow = date('d');

        $monthNow = date('m');
        $dayOfWeek = date('l');

        //-----LOCATION----
        if ($ipAdress == $ipDefaut) {
            //------CHECK TIME------
            if ($getDay[0] != "Sunday") {
                /** Condition to have one work */

                if (Auth::user()->is_check == 1) {
                    $user->workday++;
                    $user->is_check = 0;

                }
            } else {
                return view('home')->with('status', 'Today is sunday , You can go back tomorrow');
            }
        }

        //---------SAVE CHECKWORK--------
        if ($input['time'] >= $timeStartCheckout && $input['time'] <= $timeEndCheckout) {
            if ($user->save()) {
                //id user check-in recrently
                $idHistoryMax = HistoryChecks::where('model_id', $user->id)->get()->max('id');
                //get history User to Save
                $historyUser = HistoryChecks::where('model_id', $user->id)->where('id', $idHistoryMax)->first();

                $historyUser->checkout_time = '17:00:00';
                $historyUser->description = null;
                $historyUser->OT_time = null;
                $historyUser->save();
                return redirect('/home')->with('status', 'Checkout Success');
            }
            return redirect('/')->with('status', 'Checked Fail');

        } else {
            if ($input['time'] <= $timeStartCheckout) {
                if ($user->save()) {
                    //id user check-in recrently
                    $idHistoryMax = HistoryChecks::where('model_id', $user->id)->get()->max('id');
                    //get history User to Save
                    $historyUser = HistoryChecks::where('model_id', $user->id)->where('id', $idHistoryMax)->first();

                    $historyUser->checkout_time = $input['time'];
                    $historyUser->description = $input['descript'];
                    $historyUser->OT_time = null;
                    $historyUser->save();
                    return redirect('/home')->with('status', 'Checkout Success');
                }
                return redirect('/')->with('status', 'Checked Fail');
            } else {
                if ($user->save()) {
                    //id user check-in recrently
                    $idHistoryMax = HistoryChecks::where('model_id', $user->id)->get()->max('id');
                    //get history User to Save
                    $historyUser = HistoryChecks::where('model_id', $user->id)->where('id', $idHistoryMax)->first();

                    $historyUser->checkout_time = $config->timeStartCheckout;
                    $historyUser->description = $input['descript'];
                    $historyUser->OT_time = Carbon\Carbon::parse($input['time'])->diff(Carbon\Carbon::parse($config->timeEndCheckout))->format('%h:%i');
                    $historyUser->save();
                    return redirect('/home')->with('status', 'Checkout Success');
                }
                return redirect('/')->with('status', 'Checked Fail');
            }
        }

    } /* END FUNCTION */

    /**
     * mark Notification read_at.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markNotification($id)
    {
        // $notifi = Auth::user()->unreadNotifications->where('id', $id);
        foreach (Auth::user()->notifications as $notification) {
            if ($notification->id == $id) {
                $notification->update(['read_at' => now()]);
                return redirect('/notifications');
            }
        }
    }

    /**
     *
     * COnfig index View
     *
     */
    public function ConfigIndex()
    {

        $dateFormat = Configuration::first();

        $mytime = Carbon\Carbon::now();

        $timenow = date('d/m/Y',strtotime($mytime->toDateTimeString()));
        if ($dateFormat->formatDate == 'm/d/Y'){
            $timenow = date('m/d/Y',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'Y/d/m'){
            $timenow = date('Y/d/m',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'Y/m/d'){
            $timenow = date('Y/m/d',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'd/m/Y'){
            $timenow = date('d/m/Y',strtotime($mytime->toDateTimeString()));
        }

        $configes = Configuration::first();
        return view('Configurations.index', compact('configes','timenow'));
    }

    /**
     *
     * COnfig edit View
     * chú ý với:
     *          - $dateFormat->formatDate == 1 thì form day là 'm/d/Y'
     *      *   - $dateFormat->formatDate == 2 thì form day là 'd/m/Y'
     *          - $dateFormat->formatDate == 3 thì form day là 'Y/d/m'
     *          - $dateFormat->formatDate == 4 thì form day là 'Y/m/d'

     *
     */
    public function configEdit(Request $request)
    {
        $dateFormat = Configuration::first();


        $stringFormat = $dateFormat->formatDate;
        $mytime = Carbon\Carbon::now();

        $timenow = date('d/m/Y',strtotime($mytime->toDateTimeString()));
        if ($dateFormat->formatDate == 'm/d/Y'){
            $timenow = date('m/d/Y',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'Y/d/m'){
            $timenow = date('Y/d/m',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'Y/m/d'){
            $timenow = date('Y/m/d',strtotime($mytime->toDateTimeString()));
        }elseif ($dateFormat->formatDate== 'd/m/Y'){
            $timenow = date('d/m/Y',strtotime($mytime->toDateTimeString()));
        }

        $configes = Configuration::first();
        return view('Configurations.edit', compact('stringFormat','timenow','configes'));
    }

    /**
     *
     * Config update View
     *
     */
    public function configUpdate(Request $request)
    {
        $dateFormat = Configuration::first();
        $dateFormat->formatDate = $request->input('dateFormat');
        $dateFormat->save();
        $input = $request->all();
        $confifs = Configuration::first();
        $confifs->update($input);

        return redirect('/configurations');
    }

}
