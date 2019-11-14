<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');

// 선택한 post에 맞는 comment들만 불러오는 php

//POST 값을 읽어온다.
$post_id=isset($_POST['post_id']) ? $_POST['post_id'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


// 선택한 post_id에 작성된 comment들을 불러온다
$sql="select nickname, comment_user, id from Comment where post_id='$post_id'";
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
               'comment'=>$row["comment_user"],
               'id' => $row['id']
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
