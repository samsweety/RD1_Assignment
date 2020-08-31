<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Online PHP Script Execution</title>
    </head>
    <body>
        <?php
          $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=UVI&elementName=WeatherDescription&locationName=%E5%AE%9C%E8%98%AD%E7%B8%A3";
          $data=file_get_contents($url);
          $data=json_decode($data,true);
          echo "<pre>";
          print_r($data);
          

        ?>
    </body>
</html>