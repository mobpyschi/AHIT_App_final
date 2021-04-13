@extends('layouts.default')

@section('title','Create Department')

@section('content')
<div class="container-fluid">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="mt-0 header-title"  style="padding:10px"><b>Create New Notification</b></h4>
            <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('notifications.index') }}"> Back</a></div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="col-sm-12">
        <div class="card-box">

            {{-- Display Error --}}
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif {{--- end Display Error---}}
            <?php $fromname=Auth::user()->name ?>
            {{-- form Create  --}}
            {!! Form::open(array('route' => 'notifications.store','method'=>'POST')) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">

                        {!! Form::text('title',$value = $fromname, array('class' => 'form-control','hidden')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-2 col-md-2" >
                            <div class="form-group">
                                <strong>To all :</strong>
                                {!! Form::checkbox('alluser','1',false) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4" >
                            <div class="form-group">
                                <strong>To Department</strong><br>
                                {!! Form::select('department[]', $department,[], array('class'=>'form-control','multiple')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4" >
                            <div class="form-group">
                                <strong>To Person</strong>
                                {!! Form::select('user[]', $user,[], array('class'=>'form-control','id'=>'text','multiple')) !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Content :</strong>
                        {!! Form::textarea('content',null,array('maxlength'=>'500','placeholder' => 'Enter your notification.............','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
