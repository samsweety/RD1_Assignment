<?php
  $link=mysqli_connect("localhost","root","root","weather");
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
        <li class="nav-item">
            <a class="nav-link" style="color:red" href="predict.php">天氣預報</a>
        </li> 
    </ul>  
</nav>

<div class="container">   
  <table class="table table-hover">
    <thead>
      <tr>
        <th><form method="post">
        <select name="city">
          <?php           
            $sql=<<<sql
              select cid,cName from city;
            sql;
            $result=mysqli_query($link,$sql);
            for(;$row=mysqli_fetch_assoc($result);){              
            ?>
          <option value="<?=$row["cid"]?>"   <?= ($row["cid"]==$_POST["city"])?"selected":""?> ><?=$row["cName"]?></option>
          <?php }?>

        </select >
        <input type="submit" name="btnOK" class="btn-success" value="確認">
        </form>
        </th>
      </tr>
    </thead>
    
    <tbody>
     
    </tbody>
    
  </table>
</div>  
<div class="container">
<?php  
    if(isset($_POST["city"])){
    $cid=$_POST["city"];
    $sql=<<<sql
        select * from cityView where cid=$cid;
      sql;
    $result=mysqli_query($link,$sql);
    $row=mysqli_fetch_assoc($result);
      echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['pic'] ).'" width="30%" height=auto/>';
      echo "<br>";
    }
  
?>
</div>
     
</body>
</html>