@extends('layouts.default')

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
                            <td><a href="/configurations/edit" type="button" class="btn btn-primary" value="EDIT">Edit</a></td>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Time config</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">IP config</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">EMPTY</span>
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
                                <div role="tabpanel" class="tab-pane fade show active" id="home1">
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
                                                                    <td>{{$configes->timeStartCheckin}}</td>
                                                                    <td>{{$configes->timeEndCheckin}}</td>
                                                                    <td>{{$configes->timeStartCheckout}}</td>
                                                                    <td>{{$configes->timeEndCheckout}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->
                                                </div> <!-- end card-body -->
                                            </div> <!-- end card -->
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="profile1">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-centered mb-0" id="inline-editable">
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
                                                                    <td>{{$configes->ipDefaut}}</td>
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
                                    {{'content in here'}}
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings1">
                                    {{'content in here'}}
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
@endsection
