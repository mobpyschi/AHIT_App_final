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
                            @if (session('status'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

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
                                    // $timecheck = Date("15:00:00");
                                    // $timecheck = Date("19:00:00");
                                    $daycheck = Date('l:d:m:Y');
                                    $timeNow = Date("H:i:s");
                                    // $timeNow = Date("15:00:00");
                                    // $timeNow = Date("17:10:00");
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
                                        @if ($timeNow >"20:00:00" && $timeNow < "23:59:59" && Auth::user()->is_check === 0)
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
                        </div>
                    </div>
                </div><!-- end col -->
                <!-- end row -->
            </div>
 <!-- container-fluid -->

            {{-- div new --}}


        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">History Checklog Table</h4>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Time work</th>
                                    <th>OT Time</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checklog as $key => $item)
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
                                                {{Carbon\Carbon::parse($item->checkout_time)->subHours(1)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%h')}} hour
                                                {{Carbon\Carbon::parse($item->checkout_time)->diff(Carbon\Carbon::parse($item->checkin_time))->format('%i')}} minute
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
                                @endforeach
                            </tbody>
                        </table>
                        {!! $checklog->links() !!}
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-xl-7">
                <div class="card-box">

                    <h4 class="header-title mt-0 mb-3">Latest Projects</h4>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Assign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->start }}</td>
                                    <td>{{ $project->end }}</td>
                                    @if($project->status == 'overDue')
                                            <td><span class="badge badge-danger">{{ $project->status  }}</span></td>
                                            @else
                                            <td><span class="badge badge-success">{{ $project->status  }}</span></td>
                                            @endif
                                    <td>{{ $project->nameassign }}</td>
                                </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-xl-5">
                <div class="card-box">

                    <h4 class="header-title mt-0 mb-3">Latest Task</h4>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($checkTask as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->start }}</td>
                                            <td>{{ $task->end }}</td>
                                            @if($task->namestatus == 'overDue')
                                            <td><span class="badge badge-danger">{{ $task->namestatus }}</span></td>
                                            @else
                                            <td><span class="badge badge-success">{{ $task->namestatus }}</span></td>
                                            @endif
                                        </tr>
                                     @endforeach

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

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
                                            <h5 style="color: #16b31e;"><i class="fa fa-circle mr-1"></i>Progress project
                                            </h5>
                                        </li>
                                        <li class="list-inline-item float-left">
                                            <h5 style="color: #246118;"><i class="fa fa-circle mr-1"></i>Done project</h5>
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

                        <h4 class="header-title mt-0 mb-3">Latest Projects</h4>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Assign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->start }}</td>
                                            <td>{{ $project->end }}</td>
                                            <td><span class="badge badge-danger">{{ $project->status }}</span></td>
                                            <td>{{ $project->nameassign }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end col -->

            </div>
            <!-- end row -->

        </div>




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

        var m = <?php
            if (Auth::user()->project == null) {
                echo 0;
            } else {
                echo json_encode(Auth::user()->workday);
            } ?>;
        var l = <?php echo json_encode(0); ?>;
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
            colors: ["#3a2477", "#bd1820", "#16b31e", "#246118"],
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
    });
</script>

@endsection
