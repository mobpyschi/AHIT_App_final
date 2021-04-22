@extends('layouts.default')

@section('content')
    @if (Auth::user()->getRoleNames()[0] != 'Admin')
        <div class="container-fluid">
            <div class="card-header bg-dark">
                <h4 class="text-white">Attendance</h4>
            </div>
            <div class="row">
                
                <div class="col-xl-12 col-md-12">
                    <div class="card-box widget-user">
                        <div class="border border-light p-3 mb-4">
                            

                            {{-- Condition --}}
                            <div class="text-center">

                                {{-- Condition Button --}}
                                @php
                                    function get_client_ip() {
                                    $ipaddress = '';
                                    if (isset($_SERVER['HTTP_CLIENT_IP']))
                                        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                                    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                                        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                    else if(isset($_SERVER['HTTP_X_FORWARDED']))
                                        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
                                    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                                        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
                                    else if(isset($_SERVER['HTTP_FORWARDED']))
                                        $ipaddress = $_SERVER['HTTP_FORWARDED'];
                                    else if(isset($_SERVER['REMOTE_ADDR']))
                                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                                    else
                                        $ipaddress = 'UNKNOWN';
                                    return $ipaddress;
                                }
                                    $timecheck = Date('H:i:s');
                                    $daycheck = Date('l:d:m:Y');
                                    $timeNow = Date("H:i:s");
                                  
                                @endphp


                                @if ($timeNow >= $configs->timeStartCheckin && Auth::user()->is_check === 0)
                                    <form action='/home/checkin/{{ Auth::user()->id }}' method='get'>
                                        @csrf
                                        <input type='datetime' name='time' value={{ $timecheck }} hidden>
                                        <input type='datetime' name='date' value={{ $daycheck }} hidden>
                                        <input type='text' name='ip' value={{ get_client_ip() }} hidden>
                                        <input type='submit' id='btnSubmit'
                                            class='btn btn-primary btn-rounded width-md waves-effect waves-light'
                                            value='Check-in'>
                                    </form>

                                @else
                                        @if ((($timeNow >"20:00:00" && $timeNow < "23:59:59" && Auth::user()->is_check === 0) || ($timeNow >"00:00:00" && $timeNow < "05:59:59" && Auth::user()->is_check === 0))||(Auth::user()->is_check === 0) )
                                            <h4>Waiting for checkin</h4>

                                        @elseif ($timeNow >= $configs->timeStartCheckout  && $timeNow <= $configs->timeEndCheckout)

                                            <form action='/home/checkout/{{ Auth::user()->id }}' method="GET" id="checkout" onClick="return confirmSubmit()">
                                                {{-- action='/home/checkout/{{ Auth::user()->id }}' --}}
                                                @csrf
                                                <input type='datetime' name='time' value={{ $timecheck }} hidden>
                                                <input type='datetime' name='date' value={{ $daycheck }} hidden>
                                                <input type='text' name='ip' value={{ get_client_ip() }} hidden>
                                                <input type="text" name="descript"  value="" hidden>
                                                {{-- <input type='submit' id='sa-checkout'
                                                    class='btn btn-primary btn-rounded width-md waves-effect waves-light'
                                                    value='Check-out'> --}}
                                                    <button type="submit" class="btn btn-primary btn-rounded width-md waves-effect waves-light " >Check-out</button>
                                            </form>

                                        @else
                                            @if ($timeNow >$configs->timeEndCheckout && $timeNow <= "20:00:00")
                                            <a href="#checkout_late" class="btn btn-primary btn-rounded width-md waves-effect waves-light waves-effect" data-animation="slide" data-plugin="custommodal" data-overlayColor="#36404a">Check out</a>
                                                <div id="checkout_late" class="modal-demo">
                                                    <button type="button" class="close" onclick="Custombox.modal.close();">
                                                        <span>&times;</span><span class="sr-only">Close</span>
                                                    </button>

                                                    <!-- Modal body -->
                                                    <div class="custom-modal-text text-center">
                                                        <h3>Do you work over time today?</h3>
                                                        <form action='/home/checkout/{{ Auth::user()->id }}' method="GET" id="checkout" onClick="return confirmSubmit()">
                                                            {{-- action='/home/checkout/{{ Auth::user()->id }}' --}}
                                                            @csrf
                                                            <input type='datetime' name='time' value={{ $timecheck }} hidden>
                                                            <input type='datetime' name='date' value={{ $daycheck }} hidden>
                                                            <input type='text' name='ip' value={{ get_client_ip() }} hidden>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">Reason</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="descript" placeholder="What did you do?" aria-label="Username" aria-describedby="basic-addon1">
                                                            </div>
                                                            {{-- <input type='submit' id='sa-checkout'
                                                                class='btn btn-primary btn-rounded width-md waves-effect waves-light'
                                                                value='Check-out'> --}}
                                                                <button type="submit" class="btn btn-primary btn-rounded width-md mt-3 waves-effect waves-light " >Check-out</button>
                                                                <button type="button" onclick="Custombox.modal.close();" class="btn btn-danger btn-rounded mt-3 waves-effect waves-light" data-dismiss="modal">Cancel</button>
                                                        </form>


                                                    </div>
                                                </div>
                                            @elseif( $timeNow<$configs->timeStartCheckout)
                                            <a href="#checkout_early" class="btn btn-primary btn-rounded width-md waves-effect waves-light waves-effect" data-animation="slide" data-plugin="custommodal" data-overlayColor="#36404a">Check out</a>
                                            {{-- Check out modals --}}
                                                <div id="checkout_early" class="modal-demo">
                                                    <button type="button" class="close" onclick="Custombox.modal.close();">
                                                        <span>&times;</span><span class="sr-only">Close</span>
                                                    </button>

                                                    <!-- Modal body -->
                                                    <div class="custom-modal-text text-center">
                                                        <h3>Do you want to check out early?</h3>
                                                        <form action='/home/checkout/{{ Auth::user()->id }}' method="GET" id="checkout" onClick="return confirmSubmit()">
                                                            {{-- action='/home/checkout/{{ Auth::user()->id }}' --}}
                                                            @csrf
                                                            <input type='datetime' name='time' value={{ $timecheck }} hidden>
                                                            <input type='datetime' name='date' value={{ $daycheck }} hidden>
                                                            <input type='text' name='ip' value={{ get_client_ip() }} hidden>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">Reason</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="descript" placeholder="Your reason?" aria-label="Username" aria-describedby="basic-addon1">
                                                            </div>
                                                            {{-- <input type='submit' id='sa-checkout'
                                                                class='btn btn-primary btn-rounded width-md waves-effect waves-light'
                                                                value='Check-out'> --}}
                                                                <button type="submit" class="btn btn-primary btn-rounded width-md mt-3 waves-effect waves-light " >Check-out</button>
                                                                <button type="button" onclick="Custombox.modal.close();" class="btn btn-danger btn-rounded mt-3 waves-effect waves-light" data-dismiss="modal">Cancel</button>
                                                        </form>


                                                    </div>
                                                </div>
                                                {{-- end modals --}}
                                            @endif

                                        @endif
                                @endif
                            </div>
                            @if (session('status'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div><!-- end col -->
                <!-- end row -->
            </div>
 <!-- container-fluid -->

            {{-- div new --}}


        </div>
        <!-- end row -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($detailUsers->Sex == null && $detailUsers->Address == null && $detailUsers->Phone == null )
            <div class="col-xl-12 col-md-12">
                <div class="alert alert-warning" style="font-size: 1.2rem">
                    <strong>Please!</strong> Updates your profile information.
                    <a href="#custom-modal" class="btn btn-primary btn-sm waves-effect" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#36404a">Updates</a>
                    {{-- <a href="#" class="btn btn-primary">Updates</a> --}}
                </div>
            </div>
        @endif
            <div id="custom-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.modal.close();">
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title">Update Information</h4>
                <div class="col-xl-12" >
                    <form action="{{route('updateinfo',Auth::user()->id)}}" class="form-horizontal group-border-dashed"  style="overflow-y: scroll;height:30rem;padding:1rem" method="POST">
                        @csrf
                        <div class="form-group row mt-3">
                            <label class="col-sm-3 col-form-label">Full Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="Name" required
                                       placeholder="Enter Your Name"/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Sex</label>
                            <div class="col-sm-3 mt-2">
                                <div class="radio radio-info form-check-inline">
                                    <input type="radio" id="inlineRadio1" value="Males" name="Sex" checked>
                                    <label class="mr-3" for="inlineRadio1"> Males </label>
                                    <input type="radio" id="inlineRadio2" value="Females" name="Sex" >
                                    <label for="inlineRadio2"> Females </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Date of Birth" class="col-sm-3 col-form-label">Date of birth</label>
                            <div class="col-sm-6">
                                <input type="date"  class="form-control" required name="Date_of_birth" />
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Certificate</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" required name="Certificate"
                                       placeholder="Enter a valid Certificate"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="Address"
                                       required placeholder="Enter Your Address"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Residence Address</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="Residence_Address"
                                        placeholder="Enter Your Address"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-6">
                                <input data-parsley-type="number" type="number" name="Phone"
                                       class="form-control" required
                                       placeholder="Enter only your phone numbers"/>
                            </div>
                        </div>
                        
                        <div class="form-group row justify-content-center">
                            <div class="offset-sm-4 col-sm-8 mt-2">
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                                <button type="reset" onclick="Custombox.modal.close();" class="btn btn-secondary waves-effect">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                    
                </div><!-- end col -->
                
            </div>
        <div class="row">
            {{-- @can('chart-list')     --}}
            <div class="col-xl-5" style="display:none">
                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Staff Manager</h4>
                    
                    <div class="widget-chart text-center">
                        <div id="donut" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                        <ul class="list-inline chart-detail-list mb-0">
                            <li class="list-inline-item">
                                <h5 style="color: #21c72f;"><i class="fa fa-circle mr-1"></i>Work Day
                                    </h5>
                            </li>
                            <li class="list-inline-item">
                                <h5 style="color: #ff000d;"><i class="fa fa-circle mr-1"></i>Late</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- end col -->
            {{-- @endcan --}}
            <?php
                $countWorkday = $users->workday;
                
                ?>
            
            <div class="col-xl-5">
                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Staff Manager</h4>
                    
                    <div class="widget-chart text-center">
                        <div id="donut-2" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                        <ul class="list-inline chart-detail-list mb-0">
                            <li class="list-inline-item">
                                <h5 style="color: #21c72f;"><i class="fa fa-circle mr-1"></i>Work Day
                                    </h5>
                            </li>
                            <li class="list-inline-item">
                                <h5 style="color: #ff000d;"><i class="fa fa-circle mr-1"></i>Late</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-xl-7">
                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Project Manager</h4>

                    <div class="widget-chart text-center" style="margin-bottom: 36px">
                        <div class="row">
                            <div id="donut-1" dir="ltr" style="height: 245px;" class="col-md-8 morris-chart"></div>
                            <div class="col-md-4">
                                <ul class="list-inline chart-detail-list mb-0 mt-4">
                                    <li class="list-inline-item float-left">
                                        <h5 style="color: #3a2477;"><i class="fa fa-circle mr-1 "></i>Total project</h5>
                                    </li>
                                    <li class="list-inline-item float-left">
                                        <h5 style="color: #bd1820;"><i class="fa fa-circle mr-1"></i>Unfinished project
                                        </h5>
                                    </li>
                                    <li class="list-inline-item float-left">
                                        <h5 style="color: #a08cf7;"><i class="fa fa-circle mr-1"></i>Progress project
                                        </h5>
                                    </li>
                                    <li class="list-inline-item float-left">
                                        <h5 style="color: #31e10d;"><i class="fa fa-circle mr-1"></i>Done project</h5>
                                    </li>
                                </ul>

                            </div>
                        </div>


                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card-box text-light bg-warning">
                    <h4 class="header-title text-light mt-0 mb-3">History Checklog Table</h4>
                    
                        <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                            <thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                        data-tablesaw-priority="3" >Date</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Check-In</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Check-Out</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Time work</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">OT Time
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checklog as $key => $item)
                                {{-- @if ($user->email == 'admin@gmail.com')
                                    @continue
                                @endif --}}
                                    
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                        @if ($item->checkin_time == null)
                                        {{ 'Not Attendance' }} @else {{ $item->checkin_time }} @endif
                                    </td>
                                    <td>
                                        @if ($item->checkout_time == null)
                                        {{ 'Not Attendance' }} @else {{ $item->checkout_time }} @endif
                                    </td>
                                    {{-- <td><span class="badge badge-danger">Released</span></td> --}}
                                    <td>
                                        @if ($item->checkin_time == null || $item->checkout_time == null)
                                        {{ 'Not recorded workdays' }}
                                        @elseif($item->OT_time != null)
                                            {{Carbon\Carbon::parse($configs->timeStartCheckout)->subHours(1)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%h')}} hour
                                            {{Carbon\Carbon::parse($configs->timeStartCheckout)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%i')}} minute
                                        @else
                                            @if ($item->checkout_time < "13:00:00")
                                            {{Carbon\Carbon::parse($item->checkout_time)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%h')}} hour
                                            {{Carbon\Carbon::parse($item->checkout_time)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%i')}} minute
                                            @else
                                            {{Carbon\Carbon::parse($item->checkout_time)->subHours(1)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%h')}} hour
                                            {{Carbon\Carbon::parse($item->checkout_time)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%i')}} minute
                                            @endif
                                            
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->OT_time == null)
                                        Not OT
                                        @else
                                        {{$item->OT_time}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->description}}
                                    </td>
                                </tr>
                                    <tr></tr>
                                @endforeach
                            </tbody>
                        </table>
                    {!! $checklog->links() !!}
                    
                </div>
            </div><!-- end col -->

            <div class="col-xl-12">
                <div class="card-box bg-secondary text-dark">
                    <h3><p class=" header-title mt-0 mb-3 ">
                        Latest Projects
                    </p></h3>

                    <table class="tablesaw text-dark table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                        <thead >
                            <tr>
                                <th  style="background-color:rgb(155, 155, 155);color:white" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">Id</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Project Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Manager</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                            {{-- @if ($user->email == 'admin@gmail.com')
                                @continue
                            @endif --}}
                                
                                <tr>
                                    <td style="background-color:rgb(155, 155, 155);color:white"><b>{{ $project->id }}</b></td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->start)->format($formatDates.' h:m:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($project->end)->format($formatDates.' h:m:s') }}</td>
                                    @if($project->status == 'InProgress')
                                            <td><span class="badge badge-primary">{{ $project->status }}</span></td>
                                            @elseif($project->status == 'Done')
                                            <td><span class="badge badge-success">{{ $project->status }}</span></td>
                                            @else
                                            <td><span class="badge badge-danger">{{ $project->status }}</span></td>
                                            @endif
                                    <td>{{ $project->nameassign }}</td>
                                    
                                </tr>
                                
                                
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div><!-- end col -->
            
            
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card-box bg-info">
                    <h3><p class=" header-title mt-0 mb-3 ">
                        Latest Tasks
                    </p></h3>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                        <thead>
                            <tr>
                                <th style="background-color:rgb(155, 155, 155);color:white" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">#</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Task Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkTask as $task)
                            {{-- @if ($user->email == 'admin@gmail.com')
                                @continue
                            @endif --}}
                                
                                <tr>
                                    <td style="background-color:rgb(155, 155, 155);color:white">{{ $task->id }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->start)->format($formatDates.' h:m:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->end)->format($formatDates.' h:m:s') }}</td>
                                    @if($task->namestatus == 'overDue')
                                    <td><span class="badge badge-danger">{{ $task->namestatus }}</span></td>
                                    @elseif($task->namestatus == 'InProgress')
                                    <td><span class="badge badge-primary">{{ $task->namestatus }}</span></td>
                                    @else
                                    <td><span class="badge badge-success">{{ $task->namestatus }}</span></td>
                                    @endif
                                    
                                </tr>
                                
                                
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div><!-- end col -->
            <div class="col-xl-6">
                <div class="card-box text-dark">
                    <h3><p class=" header-title mt-0 mb-3 ">
                        Done Tasks
                    </p></h3>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                        <thead>
                            <tr>
                                <th style="background-color:rgb(155, 155, 155);color:white" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">#</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Task Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taskDone as $task)
                            {{-- @if ($user->email == 'admin@gmail.com')
                                @continue
                            @endif --}}
                                
                                <tr>
                                    <td style="background-color:rgb(155, 155, 155);color:white">{{ $task->id }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->start)->format($formatDates.' h:m:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->end)->format($formatDates.' h:m:s') }}</td>
                                    @if($task->namestatus == 'overDue')
                                    <td><span class="badge badge-danger">{{ $task->namestatus }}</span></td>
                                    @elseif($task->namestatus == 'InProgress')
                                    <td><span class="badge badge-primary">{{ $task->namestatus }}</span></td>
                                    @else
                                    <td><span class="badge badge-success">{{ $task->namestatus }}</span></td>
                                    @endif
                                    
                                </tr>
                                
                                
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div><!-- end col -->
            <div class="col-xl-6">
                <div class="card-box bg-danger text-dark">
                    <h3><p class=" header-title mt-0 mb-3 ">
                        OverDue Tasks
                    </p></h3>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                        <thead>
                            <tr>
                                <th style="background-color:rgb(155, 155, 155);color:white" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">#</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Task Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taskDue as $task)
                            {{-- @if ($user->email == 'admin@gmail.com')
                                @continue
                            @endif --}}
                                
                                <tr>
                                    <td style="background-color:rgb(155, 155, 155);color:white">{{ $task->id }}</td>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->start)->format($formatDates.' h:m:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->end)->format($formatDates.' h:m:s') }}</td>
                                    @if($task->namestatus == 'overDue')
                                    <td><span class="badge badge-danger">{{ $task->namestatus }}</span></td>
                                    @elseif($task->namestatus == 'InProgress')
                                    <td><span class="badge badge-primary">{{ $task->namestatus }}</span></td>
                                    @else
                                    <td><span class="badge badge-success">{{ $task->namestatus }}</span></td>
                                    @endif
                                    
                                </tr>
                                
                                
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div><!-- end col -->
            
        </div>

    @else
        <h4 class="page-title-main">Dashboard</h4>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-5">
                    <div class="card-box">
                        <h4 class="header-title mt-0 mb-3">Staff Manager</h4>
                        
                        <div class="widget-chart text-center">
                            <div id="donut" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                            <ul class="list-inline chart-detail-list mb-0">
                                <li class="list-inline-item">
                                    <h5 style="color: #9b88cf;"><i class="fa fa-circle mr-1"></i>Staff
                                        </h5>
                                </li>
                                <li class="list-inline-item">
                                    <h5 style="color: #bd1820;"><i class="fa fa-circle mr-1"></i>Departments</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end col -->
                <div class="col-xl-5" style="display:none">
                    <div class="card-box">
                        <h4 class="header-title mt-0 mb-3">Staff Manager</h4>
                        
                        <div class="widget-chart text-center">
                            <div id="donut-2" dir="ltr" style="height: 245px;" class="morris-chart"></div>
                            <ul class="list-inline chart-detail-list mb-0">
                                <li class="list-inline-item">
                                    <h5 style="color: #21c72f;"><i class="fa fa-circle mr-1"></i>Work Day
                                        </h5>
                                </li>
                                <li class="list-inline-item">
                                    <h5 style="color: #ff000d;"><i class="fa fa-circle mr-1"></i>Late</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end col -->
                <div class="col-xl-7">
                    <div class="card-box">
                        <h4 class="header-title mt-0 mb-3">Project Manager</h4>

                        <div class="widget-chart text-center" style="margin-bottom: 36px">
                            <div class="row">
                                <div id="donut-1" dir="ltr" style="height: 245px;" class="col-md-8 morris-chart"></div>
                                <div class="col-md-4">
                                    <ul class="list-inline chart-detail-list mb-0 mt-4">
                                        <li class="list-inline-item float-left">
                                            <h5 style="color: #3a2477;"><i class="fa fa-circle mr-1 "></i>Total project</h5>
                                        </li>
                                        <li class="list-inline-item float-left">
                                            <h5 style="color: #bd1820;"><i class="fa fa-circle mr-1"></i>Unfinished project
                                            </h5>
                                        </li>
                                        <li class="list-inline-item float-left">
                                            <h5 style="color: #a08cf7;"><i class="fa fa-circle mr-1"></i>Progress project
                                            </h5>
                                        </li>
                                        <li class="list-inline-item float-left">
                                            <h5 style="color: #31e10d;"><i class="fa fa-circle mr-1"></i>Done project</h5>
                                        </li>
                                    </ul>

                                </div>
                            </div>


                        </div>
                    </div>
                </div><!-- end col -->
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card-box">
                        <h3><p class=" header-title mt-0 mb-3 ">
                            Latest Projects
                        </p></h3>
    
                        <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                            <thead>
                                <tr>
                                    <th  style="background-color:rgb(155, 155, 155);color:white" scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                        data-tablesaw-priority="3">Id</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Project Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Manager</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                {{-- @if ($user->email == 'admin@gmail.com')
                                    @continue
                                @endif --}}
                                    
                                    <tr>
                                        <td style="background-color:rgb(155, 155, 155);color:white"><b>{{ $project->id }}</b></td>
                                        <td>{{ $project->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($project->start)->format($formatDates.' h:m:s') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($project->end)->format($formatDates.' h:m:s') }}</td>
                                        @if($project->status == 'InProgress')
                                                <td><span class="badge badge-primary">{{ $project->status }}</span></td>
                                                @elseif($project->status == 'Done')
                                                <td><span class="badge badge-success">{{ $project->status }}</span></td>
                                                @else
                                                <td><span class="badge badge-danger">{{ $project->status }}</span></td>
                                                @endif
                                        <td>{{ $project->nameassign }}</td>
                                        
                                    </tr>
                                    
                                    
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div><!-- end col -->
                
                
            </div>
            <!-- end row -->
            
                <div class="col-xl-12 col-md-12">
                    <div class="card-box">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="{{ route('projects.index') }}" class="dropdown-item">Project index</a>

                            </div>
                        </div>

                        <h4 class="header-title mt-0 mb-3">Done Task</h4>
                        <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch >
                            
                            </thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                        data-tablesaw-priority="3">Id</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Tasks Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Project Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start Date</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Due Date</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Status
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Worker</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Finish Time</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taskDone as $key => $task)
                                {{-- @if ($user->email == 'admin@gmail.com')
                                    @continue
                                @endif --}}
                                    
                                    <tr class="mt-3">
                                        <td>{{ $key++}}</td>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->nameProject }}</td>
                                        <td>{{ \Carbon\Carbon::parse($task->start)->format($formatDates.' h:m:s') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($task->end)->format($formatDates.' h:m:s') }}</td>
                                        @if($task->status == 'InProgress')
                                                <td><span class="badge badge-primary">{{ dd($task->status) }}</span></td>
                                                @elseif($task->status == 'Done')
                                                <td><span class="badge badge-success">{{ $task->status }}</span></td>
                                                @else
                                                <td><span class="badge badge-danger">{{ $task->status }}</span></td>
                                                @endif
                                        
                                        <td>{{ $task->nameuser }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($task->updated_at)) }}</td>
                                    </tr>
                                    <tr></tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>


    <?php $countWorkday = 0 ?>

    @endif
    </div>
   
@endsection

{{-- JS --}}
@section('js')

    <script src={{ URL::asset('libs/flot-charts/jquery.flot.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.time.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.tooltip.min.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.resize.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.pie.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.selection.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.stack.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.orderBars.js') }}></script>
    <script src={{ URL::asset('libs/flot-charts/jquery.flot.crosshair.js') }}></script>

    <!--Morris Chart-->
    <script src={{ URL::asset('libs/morris-js/morris.min.js') }}></script>
    <script src={{ URL::asset('libs/raphael/raphael.min.js') }}></script>

    <!-- Dashboard init js-->
    <script src={{ URL::asset('js/pages/dashboard.init.js') }}></script>

    <!-- init js -->
    <script src={{ URL::asset('/js/pages/flot.init.js') }}></script>

<script type = "text/javascript" >
    $(document).ready(function() {

        var m = {{$countWorkday}};
        var l = 0;
        var s = 0;
        var f = 100000;
        var colorDanger = "#FF1744";
        var tp = {{ $countProjectNames }};
        var up = {{ $countProjectUnfinished }};
        var pp = {{ $countProjectProgress }};
        var dp = {{ $countProjectDone }};
        var department = {{ $countDepartment }};
        var TotalUsers = {{ $countUserNames }};

        //worked
        Morris.Donut({
            element: 'donut',
            resize: true,
            colors: ["#bd1820","#9b88cf"],
            labelColor: "#cccccc", // text color
            //backgroundColor: '#333333', // border color
            data: [{
                    label: "Department",
                    value: department
                },
                {
                    label: "Staff",
                    value: TotalUsers
                },
            ]
        });

        // salary
        Morris.Donut({
            element: 'donut-1',
            resize: true,
            colors: ["#3a2477", "#bd1820", "#a08cf7", "#31e10d"],
            //labelColor:"#cccccc", // text color
            //backgroundColor: '#333333', // border color
            data: [{
                    label: "Total Project",
                    value: tp
                },
                {
                    label: "Unfinished Peoject",
                    value: up
                },
                {
                    label: "Progress Project",
                    value: pp
                },
                {
                    label: "Done Project",
                    value: dp
                },

            ]
        });

        Morris.Donut({
            element: 'donut-2',
            resize: true,
            colors: ["#21c72f","#ff000d"],
            labelColor: "#cccccc", // text color
            //backgroundColor: '#333333', // border color
            data: [{
                    label: "Work day",
                    value: m
                },
                {
                    label: "late",
                    value: l
                },
            ]
        });
    });
</script>

@endsection