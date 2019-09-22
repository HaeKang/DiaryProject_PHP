<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');


//POST 값을 읽어온다.
$post_id=isset($_POST['post_id']) ? $_POST['post_id'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if($state == "find"){

$sql="select nickname, title, date, content, image from Post where post_id='$post_id'";
$stmt = $con->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() == 0){

}

else{

   $data = array();

   while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        array_push($data,
               array('nickname'=>$row["nickname"],
               'title'=>$row["title"],
               'date'=>$row["date"],
               'content'=>$row["content"],
               'image'=>base64_encode($row["image"])
           ));

    }


    if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
    } else{
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("post"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
           echo $json;
       }
     }
}

else{
  $sql="delete from Post where post_id='$post_id'";
  $stmt = $con->prepare($sql);
  $stmt->execute();
}



?>


<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if (!$android){
?>

<html>
  <body>

     <form action="<?php $_PHP_SELF ?>" method="POST">
        글번호: <input type = "text" name = "post_id" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}

?>
