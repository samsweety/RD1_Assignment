<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Online PHP Script Execution</title>
    </head>
    <body>
        <?php
          $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&stationId=467550&elementName=RAIN&elementName=NOW";
          $data=file_get_contents($url);
          $data=json_decode($data,true);
        //   echo "<pre>";
        //   print_r($data);
          echo  $data["records"]["location"][0]["weatherElement"][0]["elementValue"]."=一小時累計雨量";
          echo  $data["records"]["location"][0]["weatherElement"][1]["elementValue"]."=今日累計雨量";

        ?>
    </body>
</html>