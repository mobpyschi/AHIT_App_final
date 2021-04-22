@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show User</h2>
            </div>
            
        </div>
    </div>


    <div class="row justify-content-center">
        <div class=" col-sm-10">
            <div class="card-box">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="profile-info-name text-center ">
                            <img src="/images/users/{{Auth::user()->avatar}}" class="rounded-circle avatar-xxl img-thumbnail  " alt="profile-image">
                        </div>
                    </div>
                        <div class="col-xl-8 col-md-8 offset-md-5">
                            <div class="form-group row mt-1">
                                <label class="col-sm-2 col-xs-2 col-form-label"> Name</label>
                                <div class="col-sm-6 col-xs-6 mt-1">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label class="col-sm-2 col-form-label"> Email</label>
                                <div class="col-sm-6 mt-1">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div class="form-group row mt-1">
                                <label class="col-sm-2 col-form-label"> Role</label>
                                <div class="col-sm-6 mt-1">
                                    @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label><i>{{ $v }}</i></label>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                </div>
                
                    
                
                
                <div class="pull-right text-center">
                    <a class="btn btn-primary mr-2" href="{{ route('users.index') }}"> Back</a>
                    <a class="btn btn-primary" href="{{ route('users.log', $user->id) }}"> HistoryLog</a>
                </div>
            </div>
            <div class="card-box">
                <div class="row">
                    <div class="col-md-7">
                        @foreach ($detailUser as $item)
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                    <tr>
                                        <th colspan="2"><h3 class="float-left mr-3">Profile</h3> <a href="#custom-modal-1" class=" waves-effect" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#36404a"><i style="font-size:1.2rem;margin-top:0.8rem" class="far fa-edit"></i></a></th>
                                        <div id="custom-modal-1" class="modal-demo" style="overflow: scroll">
                                            <button type="button" class="close" onclick="Custombox.modal.close();">
                                                <span>&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="custom-modal-title">Update Information</h4>
                                            <div class="col-xl-12">
                                                <form action="{{route('updateinfo',$item->user_id)}}" class="form-horizontal group-border-dashed"  style="overflow-y: scroll" method="POST">
                                                    @csrf
                                                    <div class="form-group row mt-3">
                                                        <label class="col-sm-3 col-form-label">Full Name</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="Name" required
                                                                   placeholder="Enter Your Name"/>
                                                        </div>
                                                    </div>
                            
                            
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Sex</label>
                                                        <div class="col-sm-3 mt-2">
                                                            <div class="radio radio-info form-check-inline">
                                                                <input type="radio" id="inlineRadio1" value="Males" name="Sex" checked>
                                                                <label class="mr-3" for="inlineRadio1"> Males </label>
                                                                <input type="radio" id="inlineRadio2" value="Females" name="Sex" >
                                                                <label for="inlineRadio2"> Females </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Date of Birth" class="col-sm-3 col-form-label">Date of birth</label>
                                                        <div class="col-sm-6">
                                                            <input type="date"  class="form-control" required name="Date_of_birth" />
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Certificate</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" required name="Certificate"
                                                                   placeholder="Enter a valid Certificate"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Address</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="Address"
                                                                   required placeholder="Enter Your Address"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Residence Address</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="Residence_Address"
                                                                    placeholder="Enter Your Address"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Phone</label>
                                                        <div class="col-sm-6">
                                                            <input data-parsley-type="number" type="number" name="Phone"
                                                                   class="form-control" required
                                                                   placeholder="Enter only your phone numbers"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row justify-content-center">
                                                        <div class="offset-sm-4 col-sm-8 offset-2 col-8 mt-2">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                                Submit
                                                            </button>
                                                            <button type="reset" onclick="Custombox.modal.close();" class="btn btn-secondary waves-effect">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                            
                                                
                                            </div><!-- end col -->
                                            
                                        </div>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th style="width:14rem" scope="row"><i class="fas fa-user"></i> Name</th>
                                        <td>{{ $item->Name}}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:12rem" scope="row"><i class="far fa-envelope"></i> Email</th>
                                        <td>{{ $item->Email}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" ><i class="fas fa-user-friends"></i> Sex</th>
                                        <td>{{ $item->Sex}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" ><span class="mdi mdi-cake"> Date of birth</span></th>
                                        <td>{{ date('d/m/Y ', strtotime($item->Date_of_birth)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><i class="fas fa-briefcase"></i> Start to work</th>
                                        <td>{{ date('d/m/Y ', strtotime($item->Work_start)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><i class="fas fa-briefcase"></i> Quit job</th>
                                        @if ($item->Work_end == null)
                                            <td>../../..</td>
                                        @else
                                            <td>{{ $item->Work_end}}</td>
                                        @endif
                                        
                                    </tr>
                                    <tr>
                                        <th scope="row"><span class="mdi mdi-certificate"> Certificate</span></th>
                                        <td>{{ $item->Certificate}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><i class="fas fa-phone"></i> Phone</th>
                                        <td>{{ $item->Phone}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><i class="fas fa-address-card"></i> Address</th>
                                        <td><address>{{ $item->Address}}</address></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-5 pt-3">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
