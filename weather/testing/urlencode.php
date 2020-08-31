<?php
  $link=mysqli_connect("localhost","root","root","weather");
  mysqli_query($link,"set names utf-8");
  // $sql=<<<sql
  //       select cName from city;
  //   sql;
  // $result=mysqli_query($link,$sql);
  // for(;$row=mysqli_fetch_assoc($result);){
  //   echo rawurlencode($row["cName"])."<br>";

  // }
  echo rawurlencode("2020-09-02T16:00:00");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>