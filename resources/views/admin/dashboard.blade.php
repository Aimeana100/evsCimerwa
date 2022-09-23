@extends('admin.layoult')
@section('page_title','Admin Dashboard')
@section('dashboard_selected','active')


@section('content')

<div class="main-content container-fluid">
    <div class="page-title bg-blue-100">
        <div class="row md:px-8 md:py-2 items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard </h3>
            </div>
        </div>
    </div>

    <section class="section pt-2 ">
       <div class="row mb-2">
         <div class="col-xl-4 col-md-12 mb-4">
             <div class="card">
             <div class="card-body">
                 <div class="d-flex justify-content-between p-md-1">
                 <div class="d-flex flex-row">
                     <div class="align-self-center">
                     <i class="fa fa-user text-success fa-3x me-4"></i>
                     </div>
                     <div>
                     <h4> Employees </h4>
                     <h2 class="h1 mb-0"> {{count($employees)}} </h2>
                     </div>
                 </div>
                 </div>
             </div>
             </div>
         </div>

         <div class="col-xl-4 col-md-12 mb-4">
             <div class="card">
             <div class="card-body">
                 <div class="d-flex justify-content-between p-md-1">
                 <div class="d-flex flex-row">
                     <div class="align-self-center">
                     <i class="fa fa-check text-info fa-3x me-4"></i>
                     </div>
                     <div>
                     <h4> Staff </h4>
                     <h2 class="h1 mb-0">0</h2>
                     </div>
                 </div>
                 </div>
             </div>
             </div>
         </div>

         <div class="col-xl-4 col-md-12 mb-4">
             <div class="card">
             <div class="card-body">
                 <div class="d-flex justify-content-between p-md-1">
                 <div class="d-flex flex-row">
                     <div class="align-self-center">
                     <i class="fa fa-info text-warning fa-3x me-4"></i>
                     </div>
                     <div>
                     <h4> Casual </h4>
                     <h2 class="h1 mb-0">1 </h2>
                     </div>
                 </div>
                 </div>
             </div>
             </div>
         </div>

         {{-- <div class="col-xl-4 col-md-12 mb-4">
             <div class="card">
             <div class="card-body">
                 <div class="d-flex justify-content-between p-md-1">
                 <div class="d-flex flex-row">
                     <div class="align-self-center">
                     <i class="fa fa-trash text-danger fa-3x me-4"></i>
                     </div>
                     <div>
                     <h4>Canceled</h4>
                     <h2 class="h1 mb-0">0</h2>
                     </div>
                 </div>
                 </div>
             </div>
             </div>
         </div> --}}


       </div>
    </section>

    
 </div>

@endsection

