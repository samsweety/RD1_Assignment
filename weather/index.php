<?php
  $link=mysqli_connect("localhost","sam","55688","weather");
  mysqli_query($link,"set names utf-8");
  date_default_timezone_set("Asia/Taipei");
  $weekarray=array("日","一","二","三","四","五","六");
//   $string="多雲午後短暫雷陣雨。降雨機率 30%。溫度攝氏26至34度。舒適至易中暑。東北風 風速2級(每秒2公尺)。相對濕度78%。";
//   $arr=explode("。",$string);
//   for($i=0;$i<count($arr);$i++){
//     echo $arr[$i]."<br>";
//   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>亂預報氣象網</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</head>
<body style="background-color:#FFF0AC">
<nav class="navbar navbar-expand-sm bg-info navbar-info">
  <!-- Brand/logo -->
  <a class="navbar-brand text-warning"  href="index.php">亂報</a>


    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" style="color:#484891" href="rain.php">累計雨量</a>
        </li>       
    </ul>  
</nav>

<div class="container">   
  <table class="table table-hover">
    <thead>
      <tr>
        <th><form method="post">
        <select name="city" onchange="this.form.submit()">
        <option disabled selected>>--choose--<</option>
          <?php           
            $sql=<<<sql
              select cid,cName from city;
            sql;
            $result=mysqli_query($link,$sql);
            for(;$row=mysqli_fetch_assoc($result);){              
            ?>
          <option value="<?=$row["cid"]?>"   <?= ($row["cid"]==$_POST["city"])?"selected":""?> ><?=$row["cName"]?></option>
          <?php }?>
        </select>        
        </form>        
        </th>
      </tr>
    </thead>       
  </table>  
</div>  
     
<div class="container-fluid" >
  <div class="row">
    <div class="col-6"><?php  
        if(isset($_POST["city"])){
        $cid=$_POST["city"];
        $sql=<<<sql
            select * from cityView where cid=$cid;
          sql;
        $result=mysqli_query($link,$sql);
        $row=mysqli_fetch_assoc($result);
          echo '<img src="data:image/jpeg;base64,'.base64_encode($row['pic']).'" width="100%" height=auto/>';          
        }
      
    ?>
    <table class="table" style="text-align:center">
    <?php if(isset($_POST["city"])){
      $cid=$_POST["city"];
      $sql=<<<sql
          select cName from city where cid=$cid;
        sql;
      $result=mysqli_query($link,$sql);
      $row=mysqli_fetch_assoc($result);
      $cName=$row["cName"];
      $time=strtotime("-3 hours");
      $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=WeatherDescription&locationName=".rawurlencode($cName)."&timeFrom=".date("Y-m-d")."T".rawurlencode(date("H:i:s",$time));
      $data=file_get_contents($url);
      if($data){
      $data=json_decode($data,true);
      $r=$data["records"]["locations"][0]["location"];
      $w=$r[0]["weatherElement"][0]["time"];
      
      for($i=0;$i<17;$i++){
        $startTime=$w[$i]["startTime"];
        $endTime=$w[$i]["endTime"];
        $desc=$w[$i]["elementValue"][0]["value"];  
        $descArr=explode("。",$desc);   
        $sqld=<<<sql
            delete from wd3day where location="$cName"&&starttime="$startTime";
          sql;
        mysqli_query($link,$sqld);    
        $sqldesc=<<<sql
            insert into wd3day (location,starttime,endtime,weds) values ("$cName","$startTime","$endTime","$desc");
          sql;
        mysqli_query($link,$sqldesc);
    ?>
        <tr>
          <td style="color:blue"><?= ($i==0)?"當前時間":$startTime." 到 ".substr($endTime,10)?></td>
        </tr>
        <tr>
          <td><?php for($j=0;$j<count($descArr)-1;$j++){
              if($j==4) echo "<br>";
              echo $descArr[$j]."。";
          }?></td>
        </tr>
      <?php if($i==0){?><tr><td style="color:red">未來兩天天氣預報</td></tr> <?php }
        }}else{
          echo "公開ＡＰＩ當機，顯示暫存資料";
        $sqls=<<<sql
            select starttime,endtime,weds from wd3day where location="$cName";
          sql;
        $resultf=mysqli_query($link,$sqls);
        for($i=0;$rowf=mysqli_fetch_assoc($resultf);$i++){ 
          $dsArr=explode("。",$rowf["weds"]);
          ?>

          <tr>
          <td style="color:blue"><?= ($i==0)?"當前時間":$rowf["starttime"]." 到 ".substr($rowf["endtime"],10)?></td>
        </tr>
        <tr>
          <td><?php for($j=0;$j<count($dsArr)-1;$j++){
              if($j==4) echo "<br>";
              echo $dsArr[$j]."。";    
          }?></td>
        </tr>
          
          <?php            
      }
    }}?>    
  </table>    
    </div>
    <div class="col-6">
      <?php if(isset($_POST["city"])){
        $cid=$_POST["city"];
        $sql=<<<sql
          select cName from city where cid=$cid;
        sql;
        $result=mysqli_query($link,$sql);
        $row=mysqli_fetch_assoc($result);
        $cName=$row["cName"];
        $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=UVI&elementName=WeatherDescription&locationName=".rawurlencode($cName);
        $data=file_get_contents($url);
        if($data){          
          $data=json_decode($data,true);
          $r=$data["records"]["locations"][0]["location"][0]["weatherElement"];
          $sqli="";
           ?>

            <table class="table align-middle" border="1" style="border:2px black solid;text-align:center;table-layout:fixed">
            <thead><tr><th style="width:30%">星期</th><th style="width:50%">未來一週天氣氣象</th><th style="width:20%">紫外線指數</th></tr>
            </thead><tbody>
            
            <?php for($i=0;$i<7;$i++){ 
                $datetime=substr($r[0]["time"][$i]["startTime"],0,10);
                $desc1=$r[1]["time"][$i*2]["elementValue"][0]["value"];
                $desc2=$r[1]["time"][$i*2+1]["elementValue"][0]["value"];
                $uvi=$r[0]["time"][$i]["elementValue"][0]["value"];
                $uvidesc=$r[0]["time"][$i]["elementValue"][1]["value"];
                $sqld=<<<sql
                    delete from weekpredict where cid=$cid&&preDate="$datetime";
                  sql;
                mysqli_query($link,$sqld);
                $sqli.=<<<sql
                  insert into weekpredict (cid,preDate,preDesc,uvi,uvidesc) values ($cid,"$datetime","$desc1",$uvi,"$uvidesc");
                  insert into weekpredict (cid,preDate,preDesc) values ($cid,"$datetime","$desc2");
                sql;
                
              ?>

            <tr><td  class="align-middle" rowspan="2"><?= $datetime."<br>星期".$weekarray[(date("w")+$i)%7] ?></td>

            <td style="background-color:#C4E1FF"><?= $desc1?></td>

            <td class="align-middle" rowspan="2"><?= $uvi."<br>".$uvidesc ?></td></tr>

            <tr><td style="background-color:#8080C0"><?= $desc2?></td></tr>

            <?php }?>
            </tbody>
            </table>            
            <?php       
               mysqli_multi_query($link,$sqli);
            }else{
              echo "公開ＡＰＩ當機，顯示暫存資料";
              $sqls=<<<sql
                  select * from weekpredict where cid=$cid;
                sql;
              $results=mysqli_query($link,$sqls);
           ?>

            <table class="table align-middle" border="1" style="border:2px black solid;text-align:center;table-layout:fixed">
            <thead><tr><th style="width:30%">星期</th><th style="width:50%">未來一週天氣氣象</th><th style="width:20%">紫外線指數</th></tr>
            </thead><tbody>
            
            <?php for($i=0;$rows=mysqli_fetch_assoc($results);$i++){ 
              if($i%2==0){
              ?>
            <tr><td  class="align-middle" rowspan="2"><?= $rows["preDate"]."<br>星期".$weekarray[(date("w")+$i/2)%7] ?></td> 

            <td style="background-color:#C4E1FF"><?= $rows["preDesc"]?></td>  
            
            <td class="align-middle" rowspan="2"><?= $rows["uvi"]."<br>".$rows["uvidesc"]?></td></tr>
            <?php }?>
            <?php if($i%2==1){?>
            <tr><td style="background-color:#8080C0"><?= $rows["preDesc"]?></td></tr>

            <?php }}
      }}?>
    </div>
  </div>
</div>
</body>
</html>

