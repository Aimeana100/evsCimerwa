<?php

$html ='';

function buildTaps($taps, $ymdDate){

    global $html;

    $taps = array_filter($taps, function($element){

        return date('Y-m-d', strtotime($element['tapped_at'])) == '2022-06-15';

    });

    $entering = array_filter($taps, function($element){
        return $element["status"] == 'ENTERING';
      
    });


    $exiting = array_filter($taps, function($element){
    return $element["status"] == 'EXITING';
 
    });
    

    $long_taps = count($entering) > count($exiting) ?  count($entering) : count($exiting);

    
        for($i = 0; $i < $long_taps; $i++){
        
        $html = "<div class='flex w-7' >";

        if(isset($entering[$i]))
        {
            echo "<div>" . $entering[$i] ." </div>";
        }

        if(isset($exiting[$i]))
        {
            echo "<div>" . $exiting[$i] ." </div>";
        }
        
        $html .= "</div>";
    }

    return $html;
}

?>
