<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');

// post를 삭제하거나 해당 post_id에 맞는 post의 내용, 글쓴이 등의 데이터를 불러오는 두가지 경우를 포함한 php


//POST 값을 읽어온다.
$post_id=isset($_POST['post_id']) ? $_POST['post_id'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : ''; // 글을 찾는건지 삭제하는건지 판단하는 변수
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// post를 find 하는 경우라면
if($state == "find"){

$sql="select id, nickname, title, date, content, weather from Post where post_id='$post_id'";
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
               'weather' => $row["weather"],
               'id' => $row['id']
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

// post를 삭제하는 경우라면
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
