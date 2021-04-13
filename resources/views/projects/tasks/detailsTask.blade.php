@extends('layouts.default')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-box">
        <h4 class="custom-modal-title">Detail Task</h4>
        <!-- Modal body -->
        <div class="custom-modal-text text-left">

            <div class="form-group">
                <label for="name">Task Name</label>
                <li> {{ $tasksUser->name }} </li>
            </div>

            <div class="form-group">
                <label for="name">Details</label>
                <li>{{ $tasksUser->details }}</li>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Sdate">Start Date</label>
                        <p>{{ date('Y-m-d H:i:s', strtotime($tasksUser->start)) }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Ddate"> Deadline</label>

                        @if ( (Carbon\Carbon::parse($tasksUser->end)->diffInDays( now() )) > 1)
                            <p class="text-dark"> {{ date('Y-m-d H:i:s', strtotime($tasksUser->end)) }}<br>
                            You have {{Carbon\Carbon::parse($tasksUser->end)->diffInDays( now() )}} day to work</p>
                        @else
                            <p class="text-danger">{{ date('Y-m-d H:i:s', strtotime($tasksUser->end)) }}<br>
                            Your due date is coming..You have {{Carbon\Carbon::parse($tasksUser->end)->diffInDays( now() )}} day</p>
                        @endif


                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Description</label>
                <p>@php
                    if ($tasksUser->description === null) {
                        echo 'no description';
                    } else {
                        echo $tasksUser->description;
                    }
                @endphp</p>
            </div>

            {{-- form lam viec --}}
            <p><b>Employee's </b>session :</p>
            <form action="/tasks/{{ $tasksUser->id }}/submit" method="post">
                @csrf
                <div class="row mb-3">

                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="name">Note of Employee</label>
                            <textarea name="note" class="form-control" placeholder="description your thing you're work"
                                cols="30" rows="5">{{ $tasksUser->note }}</textarea>
                            @error('description')
                                <p class="text-danger"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="custom-file">
                                <input type="file" name='filesubmit' class="custom-file-input"
                                    id="customFile{{ $tasksUser->id }}">
                                <label class="custom-file-label" for="customFile">Choose
                                    file
                                </label>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="sprogress">Progress : {{ $tasksUser->progress }}%</label>
                            <input type="range" name="progress" class="form-control" min="0" max="100" value="0">
                        </div>
                    </div>

                </div>
                <input type="submit" class="btn btn-primary waves-effect waves-light" value="Save">
                <a type="button" href="{{ route('projects.show', $tasksUser->project_id) }}" class="btn btn-danger waves-effect waves-light">Cancel</a>
            </form>

        </div>

    </div>
@endsection
