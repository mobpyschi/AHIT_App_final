@extends('layouts.default')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif




    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title" style="padding:10px"><b>Departments</b></h4>
                    @can('role-create')
                        <a class="btn btn-primary btn-rounded width-md waves-effect waves-light"
                            href="{{ route('departments.create') }}"> Create New Departments</a>
                    @endcan
                    <p class="text-muted font-15" style="padding:10px">
                        List of Departments
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                            data-tablesaw-priority="3">No</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name department</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($departments as $department)
                               @if ($department->name == 'Admin')
                                    @continue
                                @endif
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $department->name }}</td>
                                <td>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('departments.show', $department->id) }}">Show</a>
                                        @can('department-edit')
                                            <a class="btn btn-primary" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                                        @endcan


                                        @csrf
                                        @method('DELETE')
                                        @can('department-delete')
                                        @if (Auth::user()->email == 'admin@gmail.com')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        @endif

                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    {!! $departments->links() !!}

@endsection
