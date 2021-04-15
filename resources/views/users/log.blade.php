@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> History</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.show',$user->id) }}"> Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
            <div class="profile-info-name ">
                <img src="/images/users/{{Auth::user()->avatar}}" class="rounded-circle avatar-md img-thumbnail float-left " alt="profile-image">
                
                <h4 style="padding: 1rem"><strong>Name: {{ ($userDetail->Name) }}</strong></h4>
              
                
            </div>
            <div class="form-group text-center">
                
                
            </div>
        </div>
        
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">

            <h4 class="mt-0 header-title"><b>Historylogs Table</b></h4>
            <div class="row">
                <form action="{{ route('users.stlog', $user->id) }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <span style="margin:0.5rem">From </span>
                        <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="date_start">
                        <span style="margin:0.5rem">to </span>
                        <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="date_end" >
                        <span style="margin:0.2rem">
                            <button type="submit" class="btn btn-sm btn-lighten-dark btn-rounded ">Sort</button>
                        </span>

                    </div><!-- input-group -->
                </form>
            </div>

            {{-- Error Mess --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table class="tablesaw table mb-0" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $key => $item)

                        <tr>
                            <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                            <td>@if($item->checkin_time ==null) {{'Not Attendance'}} @else {{$item->checkin_time}} @endif</td>
                            <td>@if($item->checkout_time ==null) {{'Not Attendance'}} @else {{$item->checkout_time}} @endif</td>
                            <td>@if($item->checkin_time ==null || $item->checkout_time ==null) {{'Not recorded workdays'}} @else {{'recorded +1 day '}} @php $totalWork++ @endphp @endif</td>
                            <td>@if($item->decripstion == null) {{' '}} @else {{$item->decripstion}}  @endif</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            {{-- <td></td> --}}
                            <td>Totol WorkDay : {{$totalWork}}</td>
                        </tr>
                    </tbody>
            </table>
            {!! $histories->links()!!}
        </div>
    </div>
</div>
<!-- end row -->

@endsection