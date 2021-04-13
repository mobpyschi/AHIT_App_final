@extends('layouts.default')

@section('title', 'Project')

@section('css')

    <link href="libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
@endsection

@section('content')


    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-4 mb-2">
                @can('project-create')
                    <a class="btn btn-primary btn-rounded width-md waves-effect waves-light"
                        href="{{ route('projects.create') }}">Create Project</a>
                @endcan
            </div>
            <div class="col-sm-8">
                <div class="project-sort float-right">
                    <div class="project-sort-item">
                        <form class="form-inline">
                            <div class="form-group mr-2">
                                <label>Phase :</label>
                                <select class="form-control ml-2 form-control-sm">
                                    <option>All Projects(6)</option>
                                    <option>Complated</option>
                                    <option>Progress</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sort :</label>
                                <select class="form-control ml-2 form-control-sm">
                                    <option>Date</option>
                                    <option>Name</option>
                                    <option>End date</option>
                                    <option>Start Date</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col-->
        </div>
        <!-- end row -->


        <div class="row">

            @foreach ($projects as $project)
                <div class="col-xl-4">
                    <div class="card-box project-box">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                    <a href="{{ route('projects.show', $project->id) }}" class="dropdown-item">Detail</a>
                                    @can('project-edit')
                                        <a href="{{ route('projects.edit', $project->id) }}" class="dropdown-item">Edit
                                            project</a>
                                    @endcan
                                    @csrf
                                    @method('DELETE')
                                    @can('project-delete')
                                        <button type="submit" class="btn text-danger" style="width: 100%;text-colo"> Delete
                                            project {{ $project->id }}</button>
                                    @endcan
                                </form>
                            </div>
                        </div>

                        <div class="badge @if ($project->status == 'Done') badge-success
                    @elseif ($project->status == 'InProcess') badge-primary @else
                        badge-danger @endif float-right">{{ $project->status }}</div>
                    <h4 class="mt-0"><a href="{{ route('projects.show', $project->id) }}"
                            class="text-dark">{{ $project->name }}</a></h4>
                    <p class="text-success text-uppercase font-13 text-left">Web Design</p>
                    <p class="text-success text-uppercase font-13 ">Start Project: <a
                            class="text-info">{{ $project->start }}</a></p>
                    <p class="text-success text-uppercase font-13 ">End Project: <a
                            class="text-info">{{ $project->end }}</a></p>
                    <p class="text-uppercase font-13 ">Department:
                        @foreach ($departments as $department)
                            @if ($department->id == $project->department_id)
                                <a class="text-info">{{ $department->name }}</a>
                            @endif
                        @endforeach
                    </p>
                    <p class="text-muted font-13">Main Content is ...<a class="text-primary " data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">View more</a>
                    </p>
                    {{-- <ul class="list-inline">
                            <li class="list-inline-item mr-4">
                            <h4 class="mb-0">56</h4>
                            <p class="text-muted">Questions</p>
                            </li>
                            <li class="list-inline-item">
                            <h4 class="mb-0">452</h4>
                            <p class="text-muted">Comments</p>
                            </li>
                            </ul> --}}

                    <div class="project-members mb-2">
                        <h5 class="float-left mr-3">Manager :</h5>
                        <div class="avatar-group">
                            <a href="#" class="avatar-group-item" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="{{ $project->users[0]->name }}">
                                <img src="/images/users/{{ $project->users[0]->avatar }}"
                                    class="rounded-circle avatar-sm" alt="friend" />
                            </a>
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

                    <h5>Progress <span class="text-success float-right">{{ number_format($result) . '%' }}</span>
                    </h5>
                    <div class="progress progress-bar-alt-success progress-sm">
                        <div class="progress-bar bg-success progress-animated wow animated animated" role="progressbar"
                            aria-valuenow="{{ number_format($result) }}" aria-valuemin="0" aria-valuemax="100"
                            style="width: {{ number_format($result) }}%; visibility: visible; animation-name: animationProgress;">
                        </div><!-- /.progress-bar .progress-bar-danger -->
                    </div><!-- /.progress .no-rounded -->
                </div>
            </div>
        @endforeach

    </div><!-- end row -->
</div> <!-- container-fluid -->

@endsection

@section('js')
<script src="libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
@endsection
