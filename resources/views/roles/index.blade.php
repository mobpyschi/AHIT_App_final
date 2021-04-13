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

                    <h4 class="mt-0 header-title" style="padding:10px"><b>Manager Roles</b></b></h4>
                    @can('role-create')
                        <a class="btn btn-primary btn-rounded width-md waves-effect waves-light"
                            href="{{ route('roles.create') }}"> Create New Roles</a>
                    @endcan
                    <p class="text-muted font-15" style="padding:10px">
                        List of Roles
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                data-tablesaw-priority="3">ID</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                                @if ($role->name == 'Admin')
                                    @continue
                                @endif
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Show</a>
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style'
                                        => 'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    {!! $roles->render() !!}

@endsection
