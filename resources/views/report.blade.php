<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

     


        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script> --}}
        <style>
            body {
                /* font-family: 'Nunito', sans-serif; */
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                <table class="w-full md:p-4"> 
                    <thead>
                        <tr class="font-bold text-left  text-slate-600">
                            <th class="px-6 pt-5 pb-4">Names</th>
                            {{-- <th class="px-6 pt-5 pb-4">Phone</th> --}}
                            <th class="px-6 pt-5 pb-4">NID</th>
                            <th class="px-3 pt-5 pb-4 p-2">Gender</th>
                            <th class="px-6 pt-5 pb-4"> Movement </th>
                            <th class="px-6 pt-5 pb-4"> Taps </th>
                            <th class="px-6 pt-5 pb-4"> Date </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vistors as $key => $Dayitem)
        
                        @php
                        $Current_vistor_today_ID = '';
                        @endphp

                        <tr><td colspan="6" class="bg-green-200 font-bold  py-3 text-center" > {{$key}} </td> </tr>

                        @foreach ($Dayitem as $SingleDayItem)



                        @if ($Current_vistor_today_ID != $SingleDayItem->ID_Card)


                        @php
                        $Current_vistor_today_ID = $SingleDayItem->ID_Card;

                        @endphp
                        <tr
                        key="{{$key}}"
                        class="hover:bg-gray-100 px-2  focus-within:bg-gray-100"
                          >
                        <td class="border-t">
                            {{$SingleDayItem->names}}
                        </td>

                        {{-- <td class="border-t">
                            {{$item->phone}}
                        </td> --}}
                        <td class="border-t px-2 py-4 justify-center ">
                            {{$SingleDayItem->ID_Card}}
                        </td>

                        <td class="border-t p-2">
                            {{$SingleDayItem->gender}}
                        </td>

                        <td class="border-t p-2 bg-slate-100 w-[150px]">


                            @foreach ($SingleDayItem->taps as $SingleTap)

                            @if ( date('Y-m-d', strtotime($SingleTap->tapped_at)) == $key)
                                
                            @if ($SingleTap->status == "ENTERING")
                            <span class="block w-fit" > {{date('H:s', strtotime($SingleTap->tapped_at))}} </span>
                            @else
                            <span class="inline" > {{ date('H:s', strtotime($SingleTap->tapped_at ))}}</span>
                            @endif
                            @endif
                                
                            @endforeach
                        </td>

                        <td class="border-t">

                            {{count($SingleDayItem->taps)}}
                        </td>
                        <td class="border-t">
                            {{$SingleDayItem->status}}
                        </td>
                        </tr>


                        @else

                        @php
                          continue;
                      @endphp
                      
                        @endif
                            
                        @endforeach


                        @endforeach
                      
                    </tbody>
                </table>
              

               

            </div>
        </div>
    </body>
</html>
