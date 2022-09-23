@extends('admin.layoult')
@section('page_title','Visitors ')
@section('visitors_selected','active')


@section('content')

<div class="main-content container-fluid">
    
    <div class="page-title bg-blue-100">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3> Visitors </h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="text-success">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Visitors  </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

      <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active " id="personal-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

            <div style="" class=" mt-30">
                <div class="row">

                    {{-- 
                        <div class=" relative flex justify-end px-10 max-w-7xl w-2/5">
                        
                            <a  href="" class="btn btn-primary btn-sm p-2 ml-10 text-[22px] display-3 btn-flat btn-Add">
                            <i class="fa fa-plus fa-5x"></i> Apply</a>

                         </div> 
                    --}}

                    {{-- <section class="section"> --}}

                        <div class="card mt-3">
                            <div class="card-body">
                                <table  id="table1" class="table display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            {{-- 
                                                <th>Destination</th>
                                                <th>Dep-Return date </th>
                                                <th>Status</th>
                                                <th>tools</th> 
                                            --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </section> --}}
                    </div>
              </div>
        </div>

        <div class="tab-pane fade " id="office-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

            <div style="" class=" mt-30">
                <div class="row">

                    {{-- <div class=" relative flex justify-end px-10 max-w-7xl w-2/5">
                        
                        <a  href="{{route('user.requestForm')}}" class="btn btn-primary btn-sm p-2 ml-10 text-[22px] display-3 btn-flat btn-Add">
                            <i class="fa fa-plus fa-5x"></i> Apply</a>

                    </div> --}}
            
                    {{-- <section class="section"> --}}
                        <div class="card mt-3">
                            <div class="card-body">
                                <table  id="table2" class="table display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            {{-- <th>Destination</th>
                                            <th>Dep-Return date </th>
                                            <th>Status</th>
                                            <th>tools</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </section> --}}

                    </div>
              </div>

        </div>

      </div>

    
</div>




@endsection

