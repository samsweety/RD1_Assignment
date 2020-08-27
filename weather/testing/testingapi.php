<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>apitesting</title>
    </head>
    <body>
        <?php
          $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&format=JSON";
          $data=file_get_contents($url);
          $data=json_decode($data,true);
          $r=$data["records"]["locations"][0]["location"];
            for($i=0;$i<22;$i++){
                $w=$r[$i]["weatherElement"];
                echo $r[$i]["locationName"]."<br>";
                for($j=0;$j<11;$j++){
                    switch($j){
                        case 0:
                            echo "->降雨機率：<br>";
                            for($k=0;$k<6;$k++){
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["startTime"]."至".$t["endTime"]." ：".$t["elementValue"][0]["value"]."%<br>";
                            }
                        break;
                        case 1:
                            echo "->天氣：<br>";
                            for($k=0;$k<24;$k++){
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["startTime"]."至".$t["endTime"]." ：".$t["elementValue"][0]["value"]."<br>";
                            }
                        break;
                        case 2:
                            echo "->體感溫度：<br>";
                            for($k=0;$k<24;$k++){
                                if($k%4!=0)continue;
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["dataTime"]." ：".$t["elementValue"][0]["value"]."度Ｃ<br>";
                            }
                        break;
                        case 3:
                            echo "->溫度：<br>";
                            for($k=0;$k<24;$k++){
                                if($k%4!=0)continue;
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["dataTime"]." ：".$t["elementValue"][0]["value"]."度Ｃ<br>";
                            }
                        break;
                        case 4:
                            echo "->相對濕度：<br>";
                            for($k=0;$k<24;$k++){
                                if($k%4!=0)continue;
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["dataTime"]." ：".$t["elementValue"][0]["value"]."％
                                <br>";
                            }
                        break;
                        case 5:
                            echo "->舒適度：<br>";
                            for($k=0;$k<24;$k++){
                                if($k%4!=0)continue;
                                $t=$w[$j]["time"][$k];
                                echo "-->".$t["dataTime"]." ：".$t["elementValue"][0]["value"]."％
                                <br>";
                            }
                        break;
                    }

                }
                echo "<br>";
            }

        ?>
    </body>
</html>