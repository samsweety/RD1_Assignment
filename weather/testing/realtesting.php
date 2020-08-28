<?php 
    $link=mysqli_connect("localhost","root","root","weather");
    mysqli_query($link,"set names utf-8");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>realtesting</title>
    </head>
    <body>
        <?php
          $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=WeatherDescription";
          $data=file_get_contents($url);
          if($data==false){
              echo $data;
          }
          $data=json_decode($data,true);
          $r=$data["records"]["locations"][0]["location"];
            for($i=0;$i<22;$i++){
                echo "**".$r[$i]["locationName"]."<br>-->天氣預報：<br>";
                $name=$r[$i]["locationName"];
                $w=$r[$i]["weatherElement"][0]["time"];
                for($j=0;$j<24;$j++){
                    echo $w[$j]["startTime"]." 到 ".$w[$j]["endTime"]."  ：".$w[$j]["elementValue"][0]["value"]."<br><br>";
                    $starttime=$w[$j]["startTime"];
                    $endtime=$w[$j]["endTime"];
                    $wdesc=$w[$j]["elementValue"][0]["value"];
                    // $sql=<<<sql
                    //         insert into wd3day (location,starttime,endtime,wdesc) values ("$name","$starttime","$endtime","$wdesc");
                    //     sql;
                    // mysqli_query($link,$sql);
                }
                echo "<br>";
            }

        //   $name=$r[0]["locationName"];
        //   $wx=$r[0]["weatherElement"][0]["time"][0];
        //   $starttime=$wx["startTime"];
        //   $endtime=$wx["endTime"];
        //   $element=$wx["elementValue"][0]["value"];
        //   $sql=<<<sql
        //     insert into wd3day (location,starttime,endtime,wdesc) values ("$name","$starttime","$endtime","$element");
        //     sql;
        //   mysqli_query($link,$sql);
        //   echo $sql;
        ?>
    </body>
</html>