@extends('layouts.default')
@include('projects.tasks.taskUser')
@include('projects.tasks.taskboard')

@section('css')
    <!-- dropify -->
    <link href={{ URL::asset('/libs/dropify/dropify.min.css') }} rel="stylesheet" type="text/css" />

    <!-- Custom box css -->
    <link href="{{ URL::asset('/libs/custombox/custombox.min.css') }} rel=" stylesheet">
@endsection

@section('title', 'Show Project')

@section('content')
    <!-- Start Content-->
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

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
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-2">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
                </div>
            </div>
        </div>

        {{-- Only manager and admin --}}
        @if (Auth::user()->id === $project->assign || Auth::user()->getRoleNames()[0] === 'Admin')
        <div class="row">
            <div class="col-md-12">
                <div class="card-box task-detail">
                    <h4 class="header-title mt-0 mb-3">Taskboard</h4>
                    <div class="media mb-3">
                        <img class="d-flex mr-3 rounded-circle avatar-md" alt="64x64"
                            src="/images/users/{{ $getManager->avatar }}">
                        <div class="media-body">
                            <h4 class="media-heading mt-0">Manager : {{ $getManager->name }}</h4>
                        <span class="badge @if ($project->status == 'Complete') badge-success @elseif ($project->status == 'InProgress') badge-primary
                            @else badge-warning @endif">{{ $project->status }}</span>
                        </div>
                    </div>

                    <h4>Project Name : {{ $project->name }} </h4>

                    <p class="text-muted"> Information : <br>
                        - {{ $project->details }}
                        <br>
                        ** {{ $project->description }}
                    </p>

                    <div class="row task-dates mb-0 mt-2">
                        <div class="col-lg-6">
                            <h5 class="font-600 m-b-5">Start Date</h5>
                            <p>{{ date('d/m/Y H:i:s', strtotime($project->start)) }}<small class="text-muted"></small>
                            </p>
                        </div>

                        <div class="col-lg-6">
                            <h5 class="font-600 m-b-5">End Date</h5>
                            <p>{{ date('d/m/Y H:i:s', strtotime($project->end)) }}<small class="text-muted"></small></p>
                        </div>
                    </div>

                    @php
                        $sumProgress = 0;
                        $count = count($project->tasks) > 0 ? count($project->tasks) : 1;
                        if (!empty($project->tasks)) {
                            $allProjectTask = $project->tasks;
                            foreach ($allProjectTask as $task) {
                                $sumProgress += $task->progress;
                            }
                        }

                        $result = $sumProgress / $count;
                    @endphp

                    <h5>Progress <span class="text-success float-right">{{ number_format($result) . '%' }}</span></h5>
                    <div class="progress progress-bar-alt-success progress-sm">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar"
                            aria-valuenow="{{ number_format($result) }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ number_format($result) }}%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->

                    <div class="assign-team mt-4">
                        <h5>Assign to</h5>
                        <div>
                            @php
                                foreach ($getUser as $item) {
                                    echo $item . ', ';
                                }
                            @endphp
                            {{-- <a href="#"> <img class="rounded-circle avatar-sm" alt="64x64"
                                    src="/images/users/user-3.jpg"> </a>
                            <a href="#"> <img class="rounded-circle avatar-sm" alt="64x64"
                                    src="/images/users/user-5.jpg"> </a>
                            <a href="#"> <img class="rounded-circle avatar-sm" alt="64x64"
                                    src="/images/users/user-8.jpg"> </a> --}}
                        </div>
                    </div>

                    <div class="attached-files mt-4">
                        {{-- <h5>Attached Files </h5>
                        <ul class="list-inline files-list">
                            <li class="list-inline-item file-box ml-2">
                                <div class="fileupload add-new-plus">
                                    <span><i class="mdi-plus mdi"></i></span>
                                    <input type="file" class="upload">
                                </div>
                            </li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>{{-- end row --}}
        @endif

        @if (Auth::user()->id === $project->assign || Auth::user()->getRoleNames()[0] === 'Admin')
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <h4 class="header-title mt-0 mb-3">Taskboard</h4>
                        <div>
                            @yield('taskboard')
                        </div>

                    </div>

                </div><!-- end col -->
            </div><!-- end row -->
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <h4 class="header-title mt-0 mb-3">Task Status of {{Auth::user()->name}}</h4>
                        <div>
                            @yield('taskUser')
                        </div>
                    </div>
                </div><!-- end col -->
            </div>{{-- end row --}}
        @endif

    </div> <!-- container-fluid -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">

                    @include('projects.tasks.comment', ['comments' => $project->comments, 'project_id' => $project->id])

                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('comments.store') }}">
                        @csrf
                        <div class="media mb-3">
                            <div class="d-flex mr-3">
                                <a href="#"> <img class="media-object rounded-circle avatar-sm" alt="64x64"
                                        src="/images/users/{{ Auth::user()->avatar }}"> </a>
                            </div>
                            <div class="media-body">
                                <textarea name="body" class="form-control input-sm"
                                    placeholder="Some text value..."></textarea>
                                <input type=hidden name=project_id value="{{ $project->id }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <input type=submit class="btn btn-success" value="Add Comment" />
                        </div>
                    </form>
                </div>
            </div><!-- end col -->
        </div>
    </div> <!-- container-fluid -->

@endsection

@section('js')
    <!-- Jquery Ui js -->
    <script src={{ URL::asset('/libs/jquery-ui/jquery-ui.min.js') }}></script>

    <!-- dragula init -->
    <script src={{ URL::asset('/js/pages/kanban.init.js') }}></script>

    {{-- Hide Name File --}}
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>

    <script>
        !(function(e) {
            "use strict";
            var o = function() {
                this.$body = e("body");
            };
            e("#New, #InProgress, #Pending, #overDue, #Done")
                .sortable({
                    connectWith: ".taskList",
                    placeholder: "task-placeholder",
                    forcePlaceholderSize: !0,
                    update: function(o, t) {
                        e("#todo").sortable("toArray"),
                            e("#InProgress").sortable("toArray"),
                            e("#Pending").sortable("toArray"),
                            e("#overDue").sortable("toArray"),
                            e("#Done").sortable("toArray");
                    }
                })
                .disableSelection(),
                (o.prototype.init = function() {}),
                (e.KanbanBoard = new o()),
                (e.KanbanBoard.Constructor = o);
        })(window.jQuery),
        (function(o) {
            "use strict";
            window.jQuery.KanbanBoard.init();
        })();

    </script>

@endsection
