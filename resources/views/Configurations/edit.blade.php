@extends('layouts.default')

@section('css')
@endsection

@section('title', 'Config')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <h4 class="header-title mt-0 mb-3">Configuration</h4>

                    <div class="row">
                        <div class="col-xl-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#time" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Time config</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#ip" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">IP config</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Date config</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings1" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">EMPTY</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                            <form action="/configurations/update" method="post">
                                @csrf
                                <div role="tabpanel" class="tab-pane fade show active" id="time">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered mb-0" id="inline-editable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>TimeStartCheck</th>
                                                                    <th>TimeEndCheck</th>
                                                                    <th>TimeStartCheck</th>
                                                                    <th>TimeEndCheck</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td><input type="time" class="form-control" id="moreoptions" name="timeStartCheckin" value="{{$configes->timeStartCheckin}}"></td>
                                                                    <td><input type="time" class="form-control" id="moreoptions" name="timeEndCheckin" value="{{$configes->timeEndCheckin}}"></td>
                                                                    <td><input type="time" class="form-control" id="moreoptions" name="timeStartCheckout" value="{{$configes->timeStartCheckout}}"></td>
                                                                    <td><input type="time" class="form-control" id="timepicker2" name="timeEndCheckout" value="{{$configes->timeEndCheckout}}"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->
                                                </div> <!-- end card-body -->
                                            </div> <!-- end card -->
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="ip">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table" id="inline-editable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>IP default</th>
                                                                    {{-- <th>Salary</th> --}}
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    {{-- <td>{{$configes->ipDefaut}}</td> --}}
                                                                    <td><input type="text" class="form-control" id="moreoptions" name="ipDefaut" value="{{$configes->ipDefaut}}"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->
                                                </div> <!-- end card-body -->
                                            </div> <!-- end card -->
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered mb-0" id="inline-editable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Current Date Format</th>
                                                                    <th>Change Date Format</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <input value="{{ $timenow }}" type="timezone" id="meeting-time" name="meeting-time" readonly>
                                                                    </td>
{{--                                                                    {{ dd($timenow) }}--}}
                                                                    @if ($stringFormat == "Y/m/d" )
                                                                        <td>
                                                                            <br>
                                                                            <label for="dateFormat">Choose a format Date:</label>
                                                                            <select name="dateFormat" id="dateFormat">
                                                                                <option value="m/d/Y">MM/DD/YYYY</option>
                                                                                <option value="d/m/Y">DD/MM/YYYY</option>
                                                                                <option value="Y/d/m">YYYY/DD/MM</option>
                                                                                {{-- <option value="Y/m/d">YYYY/MM/DD</option> --}}

                                                                            </select>
                                                                        </td>
                                                                    @endif

                                                                    @if ($stringFormat == "Y/d/m" )
                                                                        <td>
                                                                            <br>
                                                                            <label for="dateFormat">Choose a format Date:</label>
                                                                            <select name="dateFormat" id="dateFormat">
                                                                                <option value="m/d/Y">MM/DD/YYYY</option>
                                                                                <option value="d/m/Y">DD/MM/YYYY</option>
{{--                                                                                <option value="Y/d/m">YYYY/DD/MM</option>--}}
                                                                                 <option value="Y/m/d">YYYY/MM/DD</option>
                                                                            </select>
                                                                        </td>
                                                                    @endif

                                                                    @if ($stringFormat == "d/m/Y" )
                                                                        <td>
                                                                            <br>
                                                                            <label for="dateFormat">Choose a format Date:</label>
                                                                            <select name="dateFormat" id="dateFormat">
                                                                                <option value="m/d/Y">MM/DD/YYYY</option>
{{--                                                                                <option value="d/m/Y">DD/MM/YYYY</option>--}}
                                                                                <option value="Y/d/m">YYYY/DD/MM</option>
                                                                                 <option value="Y/m/d">YYYY/MM/DD</option>
                                                                            </select>
                                                                        </td>
                                                                    @endif

                                                                    @if ($stringFormat == "m/d/Y" )
                                                                        <td>
                                                                            <br>
                                                                            <label for="dateFormat">Choose a format Date:</label>
                                                                            <select name="dateFormat" id="dateFormat">
{{--                                                                                <option value="m/d/Y">MM/DD/YYYY</option>--}}
                                                                                <option value="d/m/Y">DD/MM/YYYY</option>
                                                                                <option value="Y/d/m">YYYY/DD/MM</option>
                                                                                 <option value="Y/m/d">YYYY/MM/DD</option>
                                                                            </select>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->
                                                </div> <!-- end card-body -->
                                            </div> <!-- end card -->
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings1">
                                    {{'content in here'}}
                                </div>

                        <input type="submit" class="btn btn-primary" value="Save">
                            </form>
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection

@section('js')

@endsection

