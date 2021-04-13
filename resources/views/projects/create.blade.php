@extends('layouts.default')


@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Project</h2>
            </div>
            <div class="pull-right ">
                <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
                <a class="btn btn-primary" href="{{ route('users.create') }}"> Create new user</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('errorsMem'))
        <div class="alert alert-danger">
            {{$message}}
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="form-group">
                    <strong>Name Project:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                </div>
            </div>

            {{-- <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="form-group">
                    <div class="form-group">
                        <strong>Status Project </strong>
                        <input type="text" name="status" id="" class='form-control' value="Upcoming">
                    </div>
                </div>
            </div> --}}

            <div class="col-xs-12 col-sm-12 col-md-4 ">
                <div class="form-group">
                    <strong>Manager of Project</strong>
                    {!! Form::select('assign', $users, [], ['class' => 'form-control']) !!}

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 ">
                <div class="form-group">
                    <strong>Member of Project</strong>
                    {!! Form::select('member[]', $member, [], ['class' => 'form-control','multiple']) !!}

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detail:</strong>
                    <textarea class="form-control" style="height:150px" name="details" placeholder="Detail" >{{ old('details') }}</textarea>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 ">
                <div class="form-group">
                    <strong>Start date</strong>
                    <input type="datetime-local" name="start" class="form-control" value="{{ old('start') }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 ">
                <div class="form-group">
                    <strong>End date</strong>
                    <input type="datetime-local" name="end" class="form-control"  value="{{ old('end') }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Note or can not">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>


    </form>
@endsection
