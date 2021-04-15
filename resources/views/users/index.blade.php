@extends('layouts.default')


@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if (Auth::user()->email === 'admin@gmail.com')

        <div class="row">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="card-box">

                        <h4 class="mt-0 header-title"  style="padding:10px"><b>Users Management</b></h4>
                        <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('users.create') }}"> Create New User</a></div>
                        <p class="text-muted font-15" style="padding:10px">
                            List of Employee
                        </p>

                        <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                            <thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                        data-tablesaw-priority="3">Id User</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Email</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Roles</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Department
                                    </th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUsers as $key => $user)
                                @if ($user->email == 'admin@gmail.com')
                                    @continue
                                @endif
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>

                                                @endforeach
                                            @endif
                                        </td>
                                        <td><label
                                                class="badge badge-success">{{ $department[$user->department_id - 1]['name'] }}</label>
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                <a class="btn btn-info"
                                                    href="{{ route('users.show', $user->id) }}">Show</a>
                                                @can('user-edit')
                                                    @if ($user->email != 'admin@gmail.com')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                    @endif
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $allUsers->links() !!}
                    </div>
                </div>
            </div>
        </div>

    @elseif (Auth::user()->getRoleNames()[0] === 'Admin')

    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"><b>Users Management</b></h4>
                    <a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('users.create') }}"> Create New User</a>
                    <p class="text-muted font-15">
                        List of Employee
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">Id User</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Email</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Roles</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Department
                                </th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allUsers as $key => $user)
                                @if ($user->email == 'admin@gmail.com')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>

                                            @endforeach
                                        @endif
                                    </td>
                                    <td><label
                                            class="badge badge-success">{{ $department[$user->department_id - 1]['name'] }}</label>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            <a class="btn btn-info"
                                                href="/profile">Show</a>
                                            @can('user-edit')
                                                <a class="btn btn-primary"
                                                    href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            @endcan


                                            @csrf
                                            @method('DELETE')
                                            @can('user-delete')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @else {{-- Cac truong hop con lai --}}

    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card-box">

                    <h4 class="mt-0 header-title"  style="padding:10px"><b>Users Management</b></h4>
                    <div><a class="btn btn-primary btn-rounded width-md waves-effect waves-light" href="{{ route('users.create') }}"> Create New User</a></div>
                    <p class="text-muted font-15" style="padding:10px">
                        List of Employee
                    </p>

                    <table class="tablesaw table mb-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                    data-tablesaw-priority="3">Id User</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Email</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Roles</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Department
                                </th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                            @if ($user->email == 'admin@gmail.com')
                                @continue
                            @endif
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>

                                            @endforeach
                                        @endif
                                    </td>
                                    <td><label
                                            class="badge badge-success">{{ $department[$user->department_id - 1]['name'] }}</label>
                                    </td>
                                    <td>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            <a class="btn btn-info"
                                                href="/profile">Show</a>
                                            @can('user-edit')
                                                @if ($user->email != 'admin@gmail.com')
                                                <a class="btn btn-primary"
                                                    href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                @endif
                                            @endcan
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @endif

@endsection
