@section('taskboard')

    {{-- Phần hiển thị các TASK --}}
    <div class="row"
        style="background: #e9f3ce;display: inline-block;padding: 12px;border-radius: 3px;width: 100%;white-space: nowrap;overflow-x: scroll;min-height: 600px;">
        @foreach ($getAllStatus as $key => $status)
            @php
                $getTaskOfStatus = $taskOfStatus[$key];
            @endphp

            <div class="col-xl-4"
                style="width: 20rem;margin-right: 8px;background: #e2e4e6;border-radius: 3px;display: inline-block;vertical-align: top;font-size: 0.9em;">
                <div class="card-box taskboard-box">

                    @if (Auth::user()->getRoleNames()[0] == 'Admin' || Auth::user()->id == $getManager->id)

                        <div class="dropdown float-right">
                            <a href="custom-modal" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="#custom-modal" class="dropdown-item" data-animation="fadein"
                                    data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a">Add Task -
                                    {{ $status->name }}</a>
                            </div>
                        </div>

                    @endif

                    <h4 class="header-title mt-0 mb-3 text-primary">{{ $status->name }}</h4>

                    <ul class="sortable-list list-unstyled taskList" id="{{ $status->name }}"> {{-- upcoming --}}

                        @if (count($getTaskOfStatus))

                            @foreach ($getTaskOfStatus as $task)

                                {{-- Taks --}}
                                <li>
                                    <div class="kanban-box">

                                        @can('project-list')
                                            <div class="dropdown float-right">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('project-create')
                                                        <!-- item-->
                                                        <a href="#custom-edit-modal{{ $task->id }}" class="dropdown-item"
                                                            data-animation="fadein" data-plugin="custommodal"
                                                            data-overlaySpeed="200" data-overlayColor="#36404a">Edit</a>
                                                    @endcan

                                                    <!-- item-->
                                                    <a class="dropdown-item"
                                                        href="{{ route('taskstatus.update', [$task, 2]) }}"
                                                        role="button">InProgress</a>
                                                    <!-- item-->
                                                    <a class="dropdown-item"
                                                        href="{{ route('taskstatus.update', [$task, 3]) }}"
                                                        role="button">Pending</a>

                                                    @can('project-create')
                                                        <!-- item-->
                                                        @if ($task->progress > 0)
                                                            <!-- item-->
                                                            <a class="dropdown-item"
                                                                href="{{ route('taskstatus.update', [$task, 4]) }}"
                                                                role="button">overDue</a>
                                                            <!-- item-->
                                                            <a class="dropdown-item"
                                                                href="{{ route('taskstatus.update', [$task, 5]) }}"
                                                                role="button">Done</a>
                                                        @endif
                                                        <!-- item-->
                                                        <a class="dropdown-item" href="{{ route('taskstatus.delete', $task) }}"
                                                            role="button">Delete</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endcan

                                        <div class="kanban-detail">
                                            {{-- nut check --}}
                                            {{-- <div class="checkbox-wrapper float-left ">
                                                <div class="checkbox checkbox-success checkbox-single">
                                                    <input type="checkbox" id="singleCheckbox2" value=""
                                                        aria-label="Single checkbox Two">
                                                    <label></label>
                                                </div>
                                            </div> --}}

                                            {{-- <span class="badge badge-danger float-right">trangthai</span> --}}
                                            <h5 class="mt-0"><a href="#custom-show-modal{{ $task->id }}"
                                                    class="text-dark" data-animation="fadein" data-plugin="custommodal"
                                                    data-overlaySpeed="300"
                                                    data-overlayColor="#36404a">{{ $task->name }}</a> </h5>

                                            @if ($task->note != null)
                                                Employee note : {{ $task->note }}
                                            @endif
                                            <ul class="list-inline">

                                                <li class="list-inline-item">
                                                    <a href="" data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="{{ $task->users->name }}">
                                                        <img src="/images/users/{{ $task->users->avatar }}" alt="img"
                                                            class="avatar-sm rounded-circle">
                                                    </a>
                                                </li>

                                                <li class="list-inline-item">
                                                    {{-- Thanh Progress --}}
                                                    <h5>Progress : <span
                                                            class="text-success float-right">{{ $task->progress . '%' }}</span>
                                                    </h5> {{-- /count($project->tasks) --}}
                                                    <div class="progress progress-bar-alt-success progress-sm">
                                                        <div class="progress-bar bg-success progress-animated wow animated animated"
                                                            role="progressbar" aria-valuenow="{{ $task->progress }}"
                                                            aria-valuemin="0" aria-valuemax="100"
                                                            style="width: {{ $task->progress }}%; visibility: visible; animation-name: animationProgress;">
                                                        </div><!-- /.progress-bar .progress-bar-danger -->
                                                    </div><!-- /.progress .no-rounded -->
                                                </li>

                                                <li class="list-item" @if ($status->id == 4) style="color:red" @endif>
                                                    Deadline : {{ $task->end }}
                                                </li>
                                            </ul>

                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle waves-effect"
                                                    data-toggle="dropdown" aria-expanded="false"> Move to <i
                                                        class="mdi mdi-chevron-down"></i> </button>
                                                <div class="dropdown-menu">

                                                </div>
                                            </div> --}}

                                        </div>
                                    </div>
                                </li>{{-- End Task --}}


                                {{-- Action Model Show --}}
                                <div id="custom-show-modal{{ $task->id }}" class="modal-demo"
                                    style="overflow: scroll;">
                                    <button type="button" class="close" onclick="Custombox.modal.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Detail Task</h4>
                                    <!-- Modal body -->
                                    <div class="custom-modal-text text-left">

                                        <div class="form-group">
                                            <label for="name">Task Name</label>
                                            <li> {{ $task->name }} </li>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Details</label>
                                            <li>{{ $task->details }}</li>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="assign">Assign to</label>
                                                    <p>@php
                                                        foreach ($getUser as $key => $value) {
                                                            if ($task->assign === $key) {
                                                                echo $value;
                                                            }
                                                        }
                                                    @endphp</p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Sdate">Start Date</label>
                                                    <p>{{ date('Y-m-d H:i:s', strtotime($task->start)) }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Ddate"> Deadline</label>
                                                    <p>{{ date('Y-m-d H:i:s', strtotime($task->end)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Description</label>
                                            <p>@php
                                                if ($task->description === null) {
                                                    echo 'no description';
                                                } else {
                                                    echo $task->description;
                                                }
                                            @endphp</p>
                                        </div>

                                        {{-- form lam viec --}}
                                        @if (Auth::user()->name === $task->users->name || Auth::user()->id === $project->id || Auth::user()->id === $project->assign)
                                            <p><b>Employee's </b>session :</p>
                                            <form action="/tasks/{{ $task->id }}/submit" method="post">
                                                @csrf
                                                <div class="row mb-3">

                                                    <div class="col-md-12 ">
                                                        <div class="form-group">
                                                            <label for="name">Note of Employee</label>
                                                            <textarea name="note" class="form-control"
                                                                placeholder="description your thing you're work" cols="30"
                                                                rows="5">{{ $task->note }}</textarea>
                                                            @error('description')
                                                                <p class="text-danger"> {{ $message }} </p>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="col-md-6">
                                                            <div class="custom-file">
                                                                <input type="file" name='filesubmit'
                                                                    class="custom-file-input"
                                                                    id="customFile{{ $task->id }}">
                                                                <label class="custom-file-label" for="customFile">Choose
                                                                    file
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-8">
                                                            <label for="sprogress">Progress : {{ $task->progress }}
                                                                %</label>
                                                            <input type="range" name="progress" class="form-control" min="0"
                                                                max="100" step="1" value="{{ $task->progress }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light"
                                                    value="Save">
                                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                                    data-dismiss="modal" onclick="Custombox.modal.close();">Cancel</button>
                                            </form>
                                        @endif{{-- End form --}}

                                    </div>
                                </div>{{-- End --}}

                                {{-- Action Model Edit --}}
                                <div id="custom-edit-modal{{ $task->id }}" class="modal-demo"
                                    style="overflow: scroll;">
                                    <button type="button" class="close" onclick="Custombox.modal.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Edit</h4>
                                    <!-- Modal body -->
                                    <div class="custom-modal-text text-left">

                                        <form role="form" action="/tasks/{{ $task->id }}/edit" method="POST"
                                            onsubmit="return test()">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Task Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $task->name }}" placeholder="name task">
                                            </div>

                                            <div class="form-group">
                                                <label for="name">details</label>
                                                <input type="text" class="form-control" name="details"
                                                    value="{{ $task->details }}" placeholder="note of task">
                                            </div>

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="assign">Assign to</label>
                                                        {!! Form::select('assign', $getUser, [], ['class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Sdate">Start Date</label>
                                                        {{-- <p>{{ date('Y-m-d H:i:s', strtotime($task->start)) }}</p> --}}
                                                        <input type="datetime-local" id="start" name="start"
                                                            value="{{ date('Y-m-d\TH:i:s', strtotime($task->start)) }}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="Ddate">Due Date</label>
                                                        <input type="datetime-local" name="end"
                                                            value="{{ date('Y-m-d\TH:i:s', strtotime($task->end)) }}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Description</label>
                                                <input type="text" class="form-control" name="description"
                                                    value="{{ $task->description }}" placeholder="note of task">
                                            </div>

                                            <input type="text" class="form-control" name="project_id"
                                                value="{{ $task->project_id }}" hidden>
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light mr-1">Save</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                                onclick="Custombox.modal.close();" data-dismiss="modal">Cancel</button>

                                        </form>
                                    </div>
                                </div>{{-- end --}}

                            @endforeach

                        @endif

                    </ul>

                </div>
            </div><!-- end col -->

        @endforeach

    </div><!-- end row -->

    {{-- Action Model Create --}}
    <div id="custom-modal" class="modal-demo" style="overflow: scroll;">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add New</h4>

        <div class="custom-modal-text text-left">

            <form role="form" action="/tasks/{{ $project->id }}/save" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Task Name</label>
                    <input type="text" class="form-control" name="name" placeholder="name task"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">details</label>
                    <input type="text" class="form-control" name="details" placeholder="note of task"
                        value="{{ old('details') }}">
                    @error('details')
                        <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="assign">Assign to</label>
                    {!! Form::select('assign', $getUser, [], ['class' => 'form-control']) !!}
                    @error('assign')
                        <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Sdate">Start Date</label>
                            <input type="datetime-local" name="start" class="form-control" value="{{ old('start') }}">
                            @error('start')
                                <p class="text-danger"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Ddate">Due Date</label>
                            <input type="datetime-local" name="end" class="form-control" value="{{ old('end') }}">
                            @error('end')
                                <p class="text-danger"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">status</label>
                    {!! Form::select('status_id', $getStatusTask, [], ['class' => 'form-control']) !!}
                </div>


                <div class="form-group">
                    <label for="name">Description</label>
                    <textarea name="description" class="form-control" placeholder="description your thing true" cols="30"
                        rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger"> {{ $message }} </p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success waves-effect waves-light mr-1">Save</button>
                <button type="button" onclick="Custombox.modal.close();"
                    class="btn btn-danger waves-effect waves-light">Cancel</button>
            </form>
        </div>
    </div>{{-- end create --}}

@endsection
