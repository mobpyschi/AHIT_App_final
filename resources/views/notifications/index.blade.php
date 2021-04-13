@extends('layouts.default')


@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

@if (Auth::user()->getRoleNames()[0] === "Admin") {{--if admin--}}

    @if ($allnotifications != []) {{--if Empty--}}
    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b>Notifications</b></h4>
                    <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                    <p class="text-muted font-15" style="padding:10px">
                        List of notifications (ADMIN)
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">From</th>
                                <th >To</th>
                                <th>Message </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Time</th>
                                <th>tình trạng</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allnotifications as $key => $item)
                            <tr>
                                <td>{{$item[0]->data['title']}}</td>
                                <td> {{ $item[1] }} </td>
                                <td>{{$item[0]->data['content']}}</td>
                                <td> {{$item[0]->created_at}} - {{Carbon\Carbon::parse($item[0]->created_at)->diffForHumans(Carbon\Carbon::now())}} </td>
                                @if($item[0]->read_at == null)
                                        <td>chưa đọc</td>
                                    @else
                                        <td>Đã đọc -  {{Carbon\Carbon::parse($item[0]->read_at)->diffForHumans(Carbon\Carbon::now())}}  </td>
                                    @endif
                                <td>
                                    {{-- @can('notification-edit')
                                        <a class="btn btn-primary" href="{{ route('notifications.edit', $item[0]->id) }}">Edit</a>
                                    @endcan --}}

                                    @can('notification-delete')
                                    @if (Auth::user()->email == 'admin@gmail.com')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['notifications.destroy', $item[0]->id], 'style'
                                        => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class="card-box">

                <h4 class="mt-0 header-title"  style="padding:10px"><b>Notifications</b></h4>
                <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                <p class="text-muted font-15" style="padding:10px">
                    List of notifications (Admin)
                </p>

                <p class="font-weight-normal font-30" style="padding:10px">
                    No Notifications.
                </p>
            </div>
        </div>
    </div>
    @endif

@else {{--else lon--}}

    {{-- Xu ly dieu kien cua manager vs leader  --}}
    {{-- chua xai den  --}}
    {{-- sua 'manager vs 'leader' to 'Manager' vs 'Leader' de xai` --}}
    @if (Auth::user()->getRoleNames()[0] === 'Manager' || Auth::user()->getRoleNames()[0] === 'Leader' || Auth::user()->getRoleNames()[0] == 'Admin')

    @if ($notificationsdepartment != []){{-- xu ly dieu kien lay notiification cua department --}}
    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b> </b></h4>
                        <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                    <p class="text-muted font-15" style="padding:10px">
                        List of notifications (M)
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">From</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Message </th>
                                <th>time</th>
                                <th>tình trạng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificationsdepartment as $key =>$item)
                            <tr>
                                <td>{{$item->data['title']}}</td>
                                <td>{{$item->data['content']}}</td>
                                <td> {{$item->created_at}} - {{Carbon\Carbon::parse($item->created_at)->diffForHumans(Carbon\Carbon::now())}} </td>
                                @if($item->read_at == null)
                                    <td>chưa đọc</td>
                                @else
                                    <td>Đã đọc -  {{Carbon\Carbon::parse($item->read_at)->diffForHumans(Carbon\Carbon::now())}}  </td>
                                @endif
                                <td>
                                @if($item->notifiable_id == Auth::user()->id)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$item->id}}">
                                        Open Notification
                                    </button>

                                    {{-- Code Modal  --}}
                                    <div class="modal fade" id="myModal{{$item->id}}">
                                        <div class="modal-dialog">
                                        <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{$item->data['title']}}</h3>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <p>
                                            <div class="modal-body">
                                                <span style="font-family: Helvetica, Arial">{{htmlentities($item->data['content'])}}</span>
                                            </div>
                                        </p>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            @if ($item->read_at == null)
                                                <a class="btn btn-primary" href="{{ route('markNotification', $item->id) }}">Mark Read</a>
                                            @else
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            @endif
                                        </div>

                                    </div>
                                    </div>
                                </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b>Notifications</b></h4>
                    @if (Auth::user()->getRoleNames()[0] == 'Manager' || Auth::user()->getRoleNames()[0] == 'Leader' || Auth::user()->getRoleNames()[0] == 'Admin')
                        <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                    @endif
                    <p class="text-muted font-15" style="padding:10px">
                        List of notifications (M)
                    </p>

                    <p class="font-weight-normal font-30" style="padding:10px">
                        No Notifications.
                    </p>
                </div>
            </div>
        </div>
    @endif {{-- ket thuc xu ly dieu kien lay notiification cua department --}}

    @else

    {{-- xu ly dieu kien lay notiification cua user --}}
    @if ($usernotifications != [])
    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b>Notifications</b></h4>
                    @if (Auth::user()->getRoleNames()[0] == 'Manager' || Auth::user()->getRoleNames()[0] == 'Leader' || Auth::user()->getRoleNames()[0] == 'Admin')
                        <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                    @endif

                    <p class="text-muted font-15" style="padding:10px">
                        List of notifications (E)
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr style="text-align: center">
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">From</th>
                                <th>time</th>
                                <th>tình trạng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usernotifications as $key =>$item)
                            <tr>
                                <tr>

                                    <td>{{$item->data['title']}}</td>
                                    <td>
                                        {{$item->created_at}} -
                                        {{Carbon\Carbon::parse($item->created_at)->diffForHumans(Carbon\Carbon::now())}}
                                        </td>
                                    @if($item->read_at == null )
                                        <td>chưa đọc</td>
                                    @else
                                        <td>Đã đọc -  {{Carbon\Carbon::parse($item->read_at)->diffForHumans(Carbon\Carbon::now())}}  </td>
                                    @endif
                                    <td>
                                        <!-- Button to Open the Modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$item->id}}">
                                            Open Notification
                                        </button>

                                        {{-- Model to Open --}}
                                        <div class="modal fade" id="myModal{{$item->id}}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h3 class="modal-title">{{$item->data['title']}}</h3>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <p>
                                                    <div class="modal-body">
                                                        <span style="font-family: Helvetica, Arial">{{htmlentities($item->data['content'])}}</span>
                                                    </div>
                                                </p>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    @if ($item->read_at == null)
                                                        <a class="btn btn-primary" href="{{ route('markNotification', $item->id) }}">Mark Read</a>
                                                    @else
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    @endif
                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b>Notifications</b></h4>
                    @if (Auth::user()->getRoleNames()[0] == 'Manager' || Auth::user()->getRoleNames()[0] == 'Leader' || Auth::user()->getRoleNames()[0] == 'Admin')
                        <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.create') }}"> Create New Notification</a></div>
                    @endif
                    <p class="text-muted font-15" style="padding:10px">
                        List of notifications (E)
                    </p>

                    <p class="font-weight-normal font-30" style="padding:10px">
                        No Notifications.
                    </p>
                </div>
            </div>
        </div>
    @endif {{-- ket thuc xu ly dieu kien lay notiification cua user --}}
    @endif {{-- ket thuc Xu ly dieu kien cua manager vs leader --}}

@endif {{--endif lon--}}
@endsection
