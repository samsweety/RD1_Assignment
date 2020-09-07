<?php
  $link=mysqli_connect("localhost","sam","55688","weather");
  mysqli_query($link,"set names utf-8");
    

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
        <select name="city" id="city" onchange="this.form.submit()">
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
        </form><form method="post">
        
          <select name="station" id="station" onchange="this.form.submit()">
          <option value="" disabled selected>>--choose--<</option>
          <?php if(isset($_POST["city"])){
            $cid=$_POST["city"];
            $sqlc=<<<sql
                select cName from city where cid=$cid;
              sql;
            $resultc=mysqli_query($link,$sqlc);
            $row=mysqli_fetch_assoc($resultc);
            $cName=$row["cName"];
            $sqls=<<<sql
                select ocode,oName from outpost where ocity="$cName";
              sql;
            $results=mysqli_query($link,$sqls);
            for(;$rows=mysqli_fetch_assoc($results);){ ?>
              <option value="<?= $rows["ocode"]?>" <?= ($rows["ocode"]==$_POST["station"])?"selected":"" ?>><?= $rows["oName"]?></option>
              <?php
            }}?>
          <input type="hidden" value="<?= $_POST["city"]?>" name="city">
          </select>
        </th>
      </tr>
      </form>
    </thead>
    
    <tbody>
     
    </tbody>
    
  </table>
</div>  
<div class="container">
  <div class="row">
    <div class="col-6">
      <?php  
          if(isset($_POST["city"])){
          $cid=$_POST["city"];
          $sql=<<<sql
              select * from cityView where cid=$cid;
            sql;
          $result=mysqli_query($link,$sql);
          $row=mysqli_fetch_assoc($result);
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['pic'] ).'" width="100%" height=auto/>';
            echo "<br>";
          }        
      ?>
    </div>

    <div class="col-6">
      <table class="table">
          <?php if(isset($_POST["station"])){
            $ocode=$_POST["station"];
            $url="https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-CB17D7D0-16B0-499C-B985-3746EFEE37A4&elementName=RAIN&elementName=NOW&stationId=".$_POST["station"];
            $data=file_get_contents($url);
            if($data){
            $data=json_decode($data,true);
            $r=$data["records"]["location"][0]["weatherElement"];
            $rain1=($r[0]["elementValue"]>0)?$r[0]["elementValue"]:0.00;
            $rain24=($r[1]["elementValue"]>0)?$r[1]["elementValue"]:0.00;
            $sql=<<<sql
                delete from rain where ocode="$ocode";
              sql;
            mysqli_query($link,$sql);
            $sqli=<<<sql
                insert into rain (ocode,aHour,aDay) values ("$ocode",$rain1,$rain24);
              sql;
            mysqli_query($link,$sqli);
            ?>            
            <thead>
              <tr>
                <th>編號</th>
                <th><?= $ocode?></th>
              </tr>
            </thead>
            <tbody>
              <tr> 
                <td>近一小時累計雨量</td>
                <td><?= $rain1."mm"?></td>
              </tr>
              <tr> 
                <td>本日累計雨量</td>
                <td><?= $rain24."mm"?></td>
              </tr>
            </tbody>
            <?php
          ?>
          <?php  }else{
            echo "公開ＡＰＩ當機，顯示暫存資料";
            $sql=<<<sql
                select * from rain where ocode="$ocode";
              sql;
            $result=mysqli_query($link,$sql);
            $row=mysqli_fetch_assoc($result);?>
            <thead>
            <tr>
              <th>編號</th>
              <th><?= $row["ocode"]?></th>
            </tr>
          </thead>
          <tbody>
            <tr> 
              <td>近一小時累計雨量</td>
              <td><?= $row["aHour"]."mm"?></td>
            </tr>
            <tr> 
              <td>本日累計雨量</td>
              <td><?= $row["aDay"]."mm"?></td>
            </tr>
          </tbody>
          <?php
          }
          }?>
            
            
            
        </table>
    </div>

  </div>
</div>
     
</body>
</html>