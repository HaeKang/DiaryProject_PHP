<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');


//POST 값을 읽어온다.
$post_id=isset($_POST['post_id']) ? $_POST['post_id'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


$sql="select nickname, comment_user from Comment where post_id='$post_id'";
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
               'comment'=>$row["comment_user"]
           ));

    }


    if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
    } else{
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("compost"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
           echo $json;
       }
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
