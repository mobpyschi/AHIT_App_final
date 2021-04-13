@extends('layouts.default')

@section('css')
    <!-- Plugin css calendar-->
    <link href={{ URL::asset('libs/fullcalendar/fullcalendar.min.css') }} rel="stylesheet" type="text/css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel='stylesheet' href='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.css' />
    <style>
    #calendar .fc-widget-header {
            background-color: #C2E6FF;
            border-color: #AED0EA;
            font-weight: normal;
            padding: 3px;
            border-radius: 3px;
        }

        #calendar .fc-event {
            box-shadow: 2px 2px 2px #706868;
        }

    </style>

@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-10">
                    <div class="card-box">
                        <div class="container">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="widget">
                        <div class="widget-body">
                            {{-- <a href="#" data-toggle="modal" data-target="#add-category"
                                        class="btn btn-lg btn-success font-16 btn-block waves-effect waves-light">
                                        <i class="fa fa-plus mr-1"></i> Create New
                                    </a> --}}
                            <h4>Note :</h4>
                            <div id="external-events" class="mt-3">
                                <div class="external-event bg-primary" data-class="bg-primary">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>New Theme
                                    Release
                                </div>
                                <div class="external-event bg-pink" data-class="bg-pink">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>My Event
                                </div>
                                <div class="external-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Meet manager
                                </div>
                                <div class="external-event bg-purple" data-class="bg-purple">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Yourself
                                </div>
                            </div>
                            <!-- checkbox -->
                            {{-- <div class="custom-control custom-checkbox mt-3">
                                <input type="checkbox" class="custom-control-input" id="drop-remove">
                                <label class="custom-control-label" for="drop-remove">Remove after drop</label>
                            </div> --}}

                        </div>
                    </div>
                </div><!-- end col -->

                <!-- BEGIN MODAL -->
                <div class="modal fade none-border" id="event-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title mt-0"><strong>Add New Event</strong></h4> --}}
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Save
                                    event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light"
                                    data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-category">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0"><strong>Add a category </strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Category Name</label>
                                            <input class="form-control form-white" placeholder="Enter name" type="text"
                                                name="category-name" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Choose Category Color</label>
                                            <select class="form-control form-white" data-placeholder="Choose a color..."
                                                name="category-color">
                                                <option value="success">Success</option>
                                                <option value="danger">Danger</option>
                                                <option value="info">Info</option>
                                                <option value="pink">Pink</option>
                                                <option value="primary">Primary</option>
                                                <option value="warning">Warning</option>
                                                <option value="inverse">Inverse</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light save-category"
                                    data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div><!-- END MODAL -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->
@endsection

@section('js')


    <!-- fullcalendar plugins -->
    <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/moment.min.js'></script>
    <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery.min.js'></script>
    <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/jquery-ui.min.js'></script>
    {{-- js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <!-- fullcalendar js -->
    <script src={{ URL::asset('js/pages/fullcalendar.init.js') }}></script>

@endsection
