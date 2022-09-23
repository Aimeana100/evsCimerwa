<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Employee Attendance </title>
    <link rel="stylesheet" href="{{asset('user_assets/assets/css/bootstrap.css') }}">
    <script defer src="{{asset('user_assets/assets/fontawesome/js/all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('user_assets/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('user_assets/assets/css/custom.css') }}">


    <style>
        .logos{
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 5px 20px;

        }

        hr{
            border: '1px solid #a0a0a0',
        }
    </style>
</head>

<body>

    <div id="main">

        <div style="" class=" mt-30">
            <div class="row">
                {{-- 
                <div class="logos">
                    <div class="logo1">
                        <img src="{{ $data['logo1'] }}" width="150" height="150" />
                    </div>
                    <div class="logo2">
                        <img src="{{ $data['logo2'] }}" width="150" height="150" />
                    </div>
                </div> --}}


                <div style="display:flex; justify-content: space-around ; padding: 5px 20px;"  class="logos">
                    <div class="logo1">
                        <img src="{{public_path('user_assets/assets/images/CIMERWALogo.png')}}" width="150" height="150" />
                    </div>
                    <div class="logo2">
                        <img src="{{ public_path('user_assets/assets/images/santech.png') }}" width="150" height="150" />
                    </div>
                </div>
                <div class="title">
                    <h1 style="text-align: center"> Staff attendance report  </h1>
                </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <table  id="table1" class="table display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                            <th> # </th>
                                        
                                            <th> Names  </th>
                                            <th> ID number </th>
                                            <th> Phone </th>
                                            <th> Department </th>
                                            <th> Movement </th>
                                            {{-- <th> Time</th> --}}
                                            {{-- <th>tools</th>  --}}
                                       
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $html ='';

                                        function buildTaps($taps, $ymdDate){

                                            global $html;

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
                                                
                                                $html = "<div class='flex d-flex row flex-row w-7' >";

                                                if(isset($entering[$i]))
                                                {
                                                    echo "<div>" .  date('H:i', strtotime($entering[$i]['tapped_at'])) ." </div>";
                                                }

                                                if(isset($exiting[$i]))
                                                {
                                                    echo "<div>" . date('H:i', strtotime($exiting[$i]['tapped_at']))  ." </div>";
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


                                

                                        $i = 1;


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

                                        {{-- <td>  <img src="{{public_path('user_assets/assets/fontawesome/svgs/solid/mortar-pestle.svg')}}" alt=""> </td> --}}
                                   
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
    
</body>
</html>