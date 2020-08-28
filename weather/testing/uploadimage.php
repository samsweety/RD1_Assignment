<?php 
    $link=mysqli_connect("localhost","root","root","weather");
    mysqli_query($link,"set names utf-8");

    
    function rearrange( $arr ){
        foreach( $arr as $key => $all ){
            foreach( $all as $i => $val ){
                $new[$i][$key] = $val;    
            }    
        }
        return $new;
    }

    

    if(isset($_POST["upload"])){

        echo "<pre>";
        print_r($_FILES);

        for($i=0;$i<2;$i++){
            $fname=$_FILES["img"]["name"][$i];
            echo $fname;
            $tmpname=$_FILES["img"]["tmp_name"][$i];
            echo $tmpname;
            $ftype=$_FILES["img"]["type"][$i];
            echo $ftype;
            $fsize=$_FILES["img"]["size"][$i];
            echo $fsize;
            $instr=fopen($tmpname,"rb");
            $file=addslashes(fread($instr,filesize($tmpname)));
            $sql=<<<sql
                    insert into cityView (cid,pic) values ($i+21,'$file');
                sql;
            mysqli_query($link,$sql);


        }


    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="img[]" multiple="multiple">
    <input type="submit" name="upload">
</form>
    
</body>
</html>