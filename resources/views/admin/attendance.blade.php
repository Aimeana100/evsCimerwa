@extends('admin.layoult')
@section('page_title','Employee attendance')
@section('empolyees_attendance_selected','active')



@section('content')


<div class="main-content container-fluid">
    
    <div class="page-title bg-blue-100">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3> Employees Attendance </h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="text-success">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> attendance  </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


        <div style="" class=" mt-30">
                <div class="row">

                        <div class="card mt-3">
                            <div class="card-body">
                                <table  id="table1" class="table display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                                <th> # </th>
                                            
                                                <th> Names  </th>
                                                <th> ID number </th>
                                                <th> Phone </th>
                                                <th> Category </th>
                                                <th> Movement </th>
                                                {{-- <th> Time</th> --}}
                                                <th>tools</th> 
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            

                                            function buildTaps($taps, $ymdDate){

                                                 $html = '';

                                                $taps = array_filter($taps, function($element){

                                                    return date('Y-m-d', strtotime($element['tapped_at'])) == '2022-06-16';

                                                });

                                                $entering = array_filter($taps, function($element){
                                                    return $element["status"] == 'ENTERING';
                                                
                                                });


                                                $exiting = array_filter($taps, function($element){
                                                return $element["status"] == 'EXITING';
                                            
                                                });

                                                $entering = array_slice($entering, 0);
                                                $exiting = array_slice($exiting, 0);
                                                

                                                $long_taps = count($entering) > count($exiting) ?  count($entering) : count($exiting);

                                                
                                                    for($i = 0; $i < $long_taps; $i++){
                                                    
                                                    $html .= "<div class='flex taps__movement flex-row w-7' >";

                                                    if(isset($entering[$i]))
                                                    {
                                                        $html .= "<div>" .  date('H:i', strtotime($entering[$i]['tapped_at'])) ." </div>";
                                                    }

                                                    if(isset($exiting[$i]))
                                                    {
                                                        $html .= "<div>" . date('H:i', strtotime($exiting[$i]['tapped_at']))  ." </div>";
                                                    }

                                                    if(isset($entering[$i]) && isset($exiting[$i]))
                                                        {
                                                            $html .=  getDiff_dates($entering[$i]['tapped_at'],$exiting[$i]['tapped_at']) ;

                                                        }

                                                    $html .= "</div>";
                                                }

                                                return $html;
                                            }

                                            function getDiff_dates($start, $end){

                                                        // $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i',$start);
                                                        // $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $end);

                                                        $dateTimeObject1 = date_create($end); 
                                                        $dateTimeObject2 = date_create($start);

                                                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                                                        
                                                        $minutes = $difference->days * 24 * 60;
                                                        $minutes += $difference->h * 60;
                                                        $minutes += $difference->i;

                                                       

                                                        if($difference->h > 1){
                                                        return $difference->h ."hours";

                                                        }
                                                        else{
                                                            return $minutes ."mins";

                                                        }


                                                        }

                                         $i= 0;

                                        @endphp

                               

                                        @foreach ($daysTaps as  $item)

                                        @if (ctype_alpha($item['ID_Card']) || strlen($item['names']) == 0 || preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $item['names']) || preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $item['phone'])) 
                                    
                                        {{--       
                                        {
                                            $hasC = false;
                                            $fake_data++;
                                        } --}}

                                        @else
                                                     
                                        <tr>
                                            <td> {{$i++}} </td>
                                            <td> {{ $item['names'] }} </td>
                                            <td> {{ $item['ID_Card'] }} </td>
                                            <td> {{ $item['phone']}} </td>
                                            <td> {{ $item['destination']}} </td>
                                            <td>

                                            {!!  buildTaps($item['taps'], date('Y-m-d')); !!}
                                            </td>

                                            <td>   </td>
                                       
                                        </tr>


                                        @endif

                                        @endforeach
                
                                    </tbody>
                                </table>
                
                
                            </div>
                        </div>

                    {{-- </section> --}}
                    </div>
            </div>
            
        </div>


    @endsection

    @section('js')
    <script>

        $(document).ready(function () {

            // $('#table1').DataTable({
                // select: true,
                // "processing": true,
                // dom: 'Bfrtip',
                // dom: 'lrtip',
                // buttons: [
                    // 'copyHtml5',
                    // 'excelHtml5',
                    // 'csvHtml5',
                    // 'pdfHtml5'
                // ]
                // });
        // });

                $('#table1').DataTable( {
                    dom: 'Bfrtip',
                    responsive: true,
                    buttons: [
                        {
                            extend: 'collection',
                            className: 'custom-html-collection',
                            buttons: [
                                '<h3>Export</h3>',
                                'pdf',
                                'csv',
                                'excel',
                                '<h3 class="not-top-heading">Column Visibility</h3>',
                                'colvis',
                                'colvis'
                            ]
                        }
                    ]
                } );




            } );


    </script>

    @endsection

