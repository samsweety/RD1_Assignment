<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Online PHP Script Execution</title>
    </head>
    <body>
        <?php
          $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=WeatherDescription";
          $data=file_get_contents($url);
          $data=json_decode($data,true);
          echo "<pre>";
          print_r($data);
          

        ?>
    </body>
</html>