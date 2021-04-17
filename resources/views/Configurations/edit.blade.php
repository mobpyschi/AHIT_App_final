@extends('layouts.default')

@section('css')
@endsection

@section('title', 'Config')

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                
                    <h4 class="header-title mt-0 mb-3">Configuration</h4>

                    <div class="row">
                        <div class="col-xl-12">
            
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a href="#home2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <span class="d-block d-sm-none"><i class="fas fa-clock"></i></span>
                                        <span class="d-none d-sm-block">Time Config</span>   
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="fas fa-map-marker-alt"></i></span>
                                        <span class="d-none d-sm-block">IP Config</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#messages2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="fas fa-calendar-week"></i></span>
                                        <span class="d-none d-sm-block">Date Config</span>  
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings2" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Empty</span>  
                                    </a>
                                </li>
                            </ul>
                            <form action="/configurations/update" method="post">
                                @csrf
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active" id="home2">
                                    <div class="card-box">
                                        <table class="tablesaw table mb-0" data-tablesaw-mode="stack">
                                            <thead>
                                            <tr>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">#</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3"><b>StartCheck-in</b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><b>EndCheck-in</b> </th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><b>StartCheck-out </b></th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4"><b>StartCheck-out </b></th>
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
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile2">
                                    <div class="card-box">
                                        <table class="tablesaw table mb-0" data-tablesaw-mode="stack">
                                            <thead>
                                            <tr>
                                                <th style="width: 10rem"  scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">#</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3"><b>Set IP</b> </th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td ><input type="text" class="form-control" id="moreoptions" name="ipDefaut" value="{{$configes->ipDefaut}}"></td>
                                                
                                            </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages2">
                                    <div class="card-box">
                                        <table class="tablesaw table mb-0" data-tablesaw-mode="stack">
                                            <thead>
                                            <tr>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><b>Current Date Format</b> </th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3"><b> Change Date Format</b></th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <tr>
                                                    <td>
                                                        <input value="{{ $timenow }}" class="mt-2 form-control" type="timezone" id="meeting-time" name="meeting-time" readonly>
                                                    </td>
                                                                                  
                                                    @if ($stringFormat == "Y/m/d" )
                                                        <td>
                                                            <div class="form-group row mt-2">
                                                                <label for="dateFormat" class="col-md-4 ml-2 col-form-label">Choose a format Date:</label>
                                                                <div class="col-md-7">
                                                                    <select name="dateFormat" id="dateFormat" class="form-control">
                                                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                                                        <option value="Y/d/m">YYYY/DD/MM</option>
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                
                                                    @if ($stringFormat == "Y/d/m" )
                                                        <td>
                                                            <div class="form-group row mt-2">
                                                                <label for="dateFormat" class="col-md-4 ml-2 col-form-label">Choose a format Date:</label>
                                                                <div class="col-md-7">
                                                                    <select name="dateFormat" id="dateFormat" class="form-control">
                                                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                                                        <option value="Y/m/d">YYYY/MM/DD</option>
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                
                                                    @if ($stringFormat == "d/m/Y" )
                                                        <td>
                                                            <div class="form-group row mt-2">
                                                                <label for="dateFormat" class="col-md-4 ml-2 col-form-label">Choose a format Date:</label>
                                                                <div class="col-md-7">
                                                                    <select name="dateFormat" id="dateFormat" class="form-control">
                                                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                                                        <option value="Y/d/m">YYYY/DD/MM</option>
                                                                        <option value="Y/m/d">YYYY/MM/DD</option>
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                
                                                    @if ($stringFormat == "m/d/Y" )
                                                        <td>
                                                            <div class="form-group row mt-2">
                                                                <label for="dateFormat" class="col-md-4 ml-2 col-form-label">Choose a format Date:</label>
                                                                <div class="col-md-7">
                                                                    <select name="dateFormat" id="dateFormat" class="form-control">
                                                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                                                        <option value="Y/d/m">YYYY/DD/MM</option>
                                                                        <option value="Y/m/d">YYYY/MM/DD</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="settings2">
                                    {{'content in here'}}
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <a href="/configurations" class="btn btn-danger btn-rounded width-lg text-center text-white mt-2 mr-2"> Back</a>
                                <input type="submit" class="btn btn-primary btn-rounded width-lg text-center mt-2" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>             
    </div> <!-- container-fluid -->
@endsection

@section('js')

@endsection

