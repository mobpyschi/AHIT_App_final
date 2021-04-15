@section('taskUser')
    <div>
        <hr style="border: 1px solid red;">

        <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                        data-tablesaw-priority="3">#</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name Task</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Detail</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Start</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">End</th>
                    <th>Status</th>
                    <th width="280px">Description</th>
                    <th>Process</th>
                    <th>Note (Action for task)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasksUser as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><a href="{{ route('task.detail', [$item->id , $item->status_id]) }}">
                                {{ $item->name }} </a></td>
                        <td>{{ $item->details }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtoTime($item->start)) }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtoTime($item->end)) }}</td>
                        <td class="text-@php
                            if ($item->status_id != '4') {
                                echo 'primary';
                            } else {
                                echo 'danger';
                            }
                        @endphp">{{ $item->statusName }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            @if ($item->progress === 0)
                                not submit
                            @else
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        style="width:{{ $item->progress }}%"> {{ $item->progress }}%
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->note }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
