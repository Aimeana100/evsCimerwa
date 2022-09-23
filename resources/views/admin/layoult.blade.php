<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title> E-vistors | @yield('page_title') </title>
       <link rel="stylesheet" href="{{asset('css/app.css')}}">
       <link rel="stylesheet" href="{{asset('js/app.js')}}">
      
      {{-- <script src="{{asset('user_assets/assets/js/jquery.min.js')}}"></script> --}}
      {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
      <link rel="stylesheet" href="{{asset('user_assets/assets/css/bootstrap.css') }}">
      <script defer src="{{asset('user_assets/assets/fontawesome/js/all.min.js') }}"></script>
      <link rel="stylesheet" href="{{ asset('user_assets/assets/vendors/chartjs/Chart.min.css') }}">
      <link rel="stylesheet" href="{{ asset('user_assets/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
      <link rel="stylesheet" href="{{ asset('user_assets/assets/css/app.css') }}">
      <link rel="stylesheet" href="{{ asset('user_assets/assets/css/custom.css') }}">
      <link rel="shortcut icon" href=" {{asset('user_assets/assets/images/CIMERWALogo.png')}}" type="image/x-icon">

      {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="{{asset('user_assets/assets/css/datatables.net/responsive.dataTables.min.css')}}">
      <link rel="stylesheet" href="{{asset('user_assets/assets/css/datatables.net/rowReorder.dataTables.min.css')}}">
 --}}

      {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/r-2.3.0/datatables.min.css"/> --}}
 
      {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> --}}
      {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}

      {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/r-2.3.0/datatables.min.js"></script> --}}
      

      {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/r-2.3.0/datatables.css"/> --}}
 

      <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">




    <link rel="stylesheet" type="text/css" href="{{asset('user_assets/assets/css/daterangepicker/daterangepicker.css')}}" />
   


    <style>
       div.dt-button-collection {
         width: 400px;
     } 
 
       div.dt-button-collection button.dt-button {
         display: inline-block;
         width: 32%;
      }
     div.dt-button-collection button.buttons-colvis {
         display: inline-block;
         width: 49%;
      }
      div.dt-button-collection h3 {
         margin-top: 5px;
         margin-bottom: 5px;
         font-weight: 100;
         border-bottom: 1px solid #9f9f9f;
         font-size: 1em;
      }
      div.dt-button-collection h3.not-top-heading {
         margin-top: 10px;
      }





    </style>



      @yield('css')

   </head>
<body>
      <div id="app">
         <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
               <div class="sidebar-header flex" style="height: 50px;margin-top: -30px">
                      {{-- <i class="fa fa-users text-success me-4"></i> --}}
                      <img class="max-w-xs" src="{{asset('user_assets/assets/images/CIMERWALogo.png')}}" alt="">
                        <span> EVS </span>
                </div>

                {{-- sidebar  --}}

               <div class="sidebar-menu mt-2">
                <ul class="menu">

                   <li class="sidebar-item @yield('dashboard_selected')">
                      <a href=" {{route('dashboard')}} " class='sidebar-link'>
                      <i class="fa fa-home text-success"></i>
                      <span>Dashboard</span>
                      </a>
                   </li>

                   <li class="sidebar-item  @yield('empolyees_attendance_selected')">
                      <a href="{{route('admin.attendance')}} " class='sidebar-link'>
                      <i class="fa fa-book text-success"></i>
                      <span> Staff Attendance </span>
                      </a>
                   </li>

                   <li class="sidebar-item @yield('empolyees_selected')">
                      <a href=" {{route('admin.employees')}} " class='sidebar-link'>
                      <i class="fa fa-user text-success"></i>
                      <span> Staff </span>
                      </a>
                   </li>
                   <li class="sidebar-item @yield('visitors_selected')">
                    <a href=" {{route('admin.visitors')}} " class='sidebar-link'>
                    <i class="fa fa-plane text-success"></i>
                    <span> Vistors </span>
                    </a>
                  </li>
                 

                 {{-- <li class="sidebar-item @yield('profile_selected')">
                    <a href=" {{route('admin.account')}} " class='sidebar-link'>
                    <i class="fa fa-user text-success"></i>
                    <span>Profile</span>
                    </a>
                 </li> --}}
                </ul>
             </div>
             <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
          </div>
       </div>


                @yield('sidebar')

                <div id="main">
                    <nav class="navbar navbar-header navbar-expand navbar-light">
                        <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                        <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                           aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                          <span>  </span>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                           <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                               @if (!auth()->user()->hasRole('user'))
                            {{--                     
                               <li class="dropdown nav-icon">
                                <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                         class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                         <path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge bg-info">2</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                    <h6 class="py-2 px-4">Notifications</h6>
                                    <ul class="list-group rounded-none">
                                        <li class="list-group-item border-0 align-items-start">
                                        <div class="row mb-2">
                                        <div class="col-md-12 notif">
                                                <a href="leave_details.html"><h6 class="text-bold">John Doe</h6>
                                                <p class="text-xs">
                                                    applied for leave at 05-21-2021
                                                </p></a>
                                            </div>
                                        <div class="col-md-12 notif">
                                                <a href="leave_details.html"><h6 class="text-bold">Jane Doe</h6>
                                                <p class="text-xs">
                                                    applied for leave at 05-21-2021
                                                </p></a>
                                            </div>
                                          </div>
                                        </li>
                                    </ul>
                                </div> 
                            </li>
                            --}}
                    
                            @endif
                    
                              <li class="drnavbarSupportedContentopdown">
                                 <a href="#" data-bs-toggle="dropdown"
                                    class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="avatar me-1">
                                        @if (auth()->user()->profile_pic)
                                        <img src="{{asset('uploads/images/profiles/'. auth()->user()->profile_pic)}}" alt="" srcset="">
                                         @else
                                        <img src="{{ asset('user_assets/assets/images/admin.png')}}" alt="" srcset="">
                                         @endif
                    
                                    </div>
                                    <div class="d-none d-md-block d-lg-inline-block"> {{ auth()->user()->last_name}} </div>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item w-full flex" href="{{route('admin.account')}} "><i data-feather="user"></i> Account</a>
                                    <a class="dropdown-item w-full flex" href="{{route('admin.editPassword')}} "><i data-feather="key"></i> Change Password </a>
                                    {{-- <a class="dropdown-item w-full flex" href="update_password.html"><i data-feather="settings"></i> Settings</a> --}}
                                    <div class="dropdown-divider"></div>
                                    <a id="l-logaut" class="dropdown-item w-full flex" href="#" onclick="event.preventDefault(); document.getElementById('frmLogaut').submit();"><i data-feather="log-out"></i> Logout</a>
                                    <form id="frmLogaut" action=" {{route('logout')}} " method="post">
                                        @csrf
                                    </form>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </nav>
                    

                @yield('content')

                    </div>
                </div>

                {{-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="crossorigin="anonymous"></script> --}}
                <script src="{{ asset('user_assets/assets/js/feather-icons/feather.min.js') }} "></script>
                <script src="{{ asset('user_assets/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
                <script src="{{ asset('user_assets/assets/js/app.js') }} "></script>
                <script src="{{ asset('user_assets/assets/vendors/chartjs/Chart.min.js') }} "></script>
                {{-- <script src="{{ asset('user_assets/assets/vendors/apexcharts/apexcharts.min.js') }} "></script> --}}
                <script src="{{ asset('user_assets/assets/js/pages/dashboard.js') }} "></script>
                <script src="{{ asset('user_assets/assets/js/main.js') }} "></script>
                <script src="{{ asset('js/jq-signature.js') }}"></script>

                <link rel="stylesheet" type="text/css" href="{{asset('user_assets/assets/css/datatables.net/bs4/dt-1.10.25/r-2.2.9/datatables.min.css')}}"/>
                <script type="text/javascript" src="{{asset('user_assets/assets/css/datatables.net/bs4/dt-1.10.25/r-2.2.9/datatables.min.js')}}"></script>

                {{-- sweet arlet --}}
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                
               {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
               <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
               <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/fh-3.2.4/r-2.3.0/datatables.js"></script>

 --}}


<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js" ></script>






                <script>

                    
                // {{-- logaut --}}
                // $('#l-logaut').click( function(e) {
                //     e.preventDefault();

                //     $('frnLogaut').submit();
                //   });

                </script>
                @yield('js')
            </body>
            </html>
