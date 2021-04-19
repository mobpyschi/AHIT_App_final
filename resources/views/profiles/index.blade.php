@extends('layouts.default')

@section('css')
    <style>
        .border_img{
            border: 3px solid;
            width: 12rem;
            min-height: 12rem;
            
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cccccc;
            border-radius: 10rem;
        }
        .show_img{
            display: none;
            width: 100%;
        }
        
    </style>
@endsection

@section('content')

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="bg-picture card-box justify-content-center">
                    <div class="row justify-content-center " >
                        
                            <div class="profile-info-name mb-2 mr-3 ml-3">
                                <img src="/images/users/{{Auth::user()->avatar}}" class="rounded-circle avatar-xxl img-thumbnail float-left" alt="profile-image">
                            </div>
                            <div class="rounded-circle img-thumbnail float-left" style="position: absolute;margin-top: 5.5rem;margin-left: .3rem;width:1.63rem;height:1.7rem" >
                                <a href="#custom-modal" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#36404a"><i style="font-size:1rem;" class="fas fa-camera"></i></a>
                            </div>
                            <div id="custom-modal" class="modal-demo">
                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                    <span>&times;</span><span class="sr-only">Close</span>
                                </button>
                                <h4 class="custom-modal-title">Update Avatar</h4>
                                <div class="custom-modal-text">
                                    <div class="col-xl-12 col-md-12" >
                                        
                                        <form  enctype="multipart/form-data" action="/profiles/avt" method="post">
                                            @csrf
                                            <div class="row justify-content-center" id="inputImg">
                                                <div class="float-center border_img" >
                                                    <img src="" class="show_img rounded-circle img-thumbnail"  alt="Upload Image">
                                                    <span class="default_text">Upload Image</span>
                                                </div>
                                            </div>
                                            <h5 scope="row" class="font-600 m-b-5 ">Avatar<input type="file" id="inpFile" style="margin-top: 0.1rem" name="avatar" class="ml-2"></h5>
                                            <div class="row justify-content-center">
                                                <div><button type="submit" style="border: none" class="btn-primary btn-rounded mt-1">Upload</button></div>
                                            </div>
                                            
                                        </form> 
                                    </div>
                                </div>
                            </div>


                            <div class=" col-md-12 profile-info-detail overflow-hidden text-center">
                                <h4 class="m-0">{{Auth::user()->name}}</h4>
                                <p class="text-muted"><i>{{Auth::user()->getRoleNames()[0]}}</i></p>
                                <p><i>Vạn sự tuỳ duyên</i></p>
    
                                <ul class="social-list list-inline mt-3 mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i
                                                class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                                class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                                class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                                class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
    
                                
                            </div>
    
                            <div class="clearfix"></div>
                        
                    </div>
                    
                </div>
                <!--/ meta -->
                

                <div class="card-box">
                    <div class="row">
                        <div class="col-md-7">
                            @foreach ($detailUser as $item)
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                        <tr>
                                            <th colspan="2"><h3 class="float-left mr-3">Profile</h3> <a href="#custom-modal-1" class=" waves-effect" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#36404a"><i style="font-size:1.2rem;margin-top:0.8rem" class="far fa-edit"></i></a></th>
                                            <div id="custom-modal-1" class="modal-demo"  style="overflow: scroll;">
                                                <button type="button" class="close" onclick="Custombox.modal.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">Update Information</h4>
                                                <div class="col-xl-12" >
                                                    <form action="{{route('updateinfo',Auth::user()->id)}}" class="form-horizontal group-border-dashed"  style="overflow-y: scroll" method="POST">
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
                                                            <div class="offset-sm-4 col-sm-8 mt-2">
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
                                            <td>
                                                {{-- {{ date('d/m/Y ', strtotime($item->Date_of_birth)) }} --}}
                                                {{ \Carbon\Carbon::parse($item->Date_of_birth)->format($formatDates) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="fas fa-briefcase"></i> Start to work</th>
                                            <td>{{ \Carbon\Carbon::parse($item->Work_start)->format($formatDates) }}</td>
                                            
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
        

    </div> <!-- container-fluid -->

@endsection

@section('js')
    <script>
        const inpFile = document.getElementById("inpFile");
        const reviewContainer = document.getElementById("inputImg");
        const reviewImg = reviewContainer.querySelector(".show_img");
        const defaltText = reviewContainer.querySelector(".default_text");

        inpFile.addEventListener("change",function () {
            const file = this.files[0];

            if(file){
                const reader = new FileReader();
                reviewImg.style.display = "Block";
                defaltText.style.display = "none";

                reader.addEventListener("load",function() {
                    // console.log(this);
                    reviewImg.setAttribute("src",this.result);
                });

                reader.readAsDataURL(file);
            }
            else{
                reviewImg.style.display = null;
                defaltText.style.display = null;
                reviewImg.setAttribute("src","");
            }
        });
    </script>
@endsection