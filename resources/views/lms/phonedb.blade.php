<?php
echo '<style>
th, td {
    border: 1px solid;
    padding: 3px;
  }
  </style>
<table>';

foreach($db as $results) {
    echo '<tr>';
    //$elements = json_decode($job, true);
    //var_dump($elements);
    foreach($results as $element) {
        if(is_string($element)) {
            
            echo '<td>';
            if(is_numeric( $element ) && floor( $element ) != $element) {
                $carbon = new Carbon\Carbon();
                $carbon->setTimestamp($element);
                $carbon->setTimezone('Australia/Brisbane');
                echo $carbon;
                /*$date = new DateTime();
                $date::setTiestamp($element);
                var_dump($date);*/
                //echo gmdate("Y-m-d\TH:i:s\Z", $element);
            } else {
            echo $element;
            }
            echo '</td>';
        } else {
            echo '<td>';
            var_dump($element);
            echo '</td>';
        }
        //echo "Is this what you came for?";
        
    }
    /*foreach($elements as $element) {
        
        while($i < count($element))
            {
                echo $element[$i]."\n";
                $i++;
            }

    }*/
    echo '</tr>';
}

echo '</table>';
?>



