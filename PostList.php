<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 모든 사용자가 공개글로 쓴 글 목록들을 불러오는 php


$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// 공개글 모두 다 가져옴
$sql="select nickname,post_id,title,date from Post where private = false ";
$stmt = $con->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() == 0){   // 글이 없을때
    echo "글이 없오";
  }

else {      // 글이 있을 때

  $data = array();

  while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

  extract($row);

  array_push($data, array('nickname'=>$row["nickname"],
                  'post_id'=>$row["post_id"],
                  'title' =>$row["title"],
                  'date' =>$row["date"]
                  )
                );
  }

  if (!$android) {
    echo "<pre>";
    print_r($data);
    echo '</pre>';
  }

  else {
    header('Content-Type: application/json; charset=utf8');
    $json = json_encode(array("postlist"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
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
        닉네임: <input type = "text" name = "nickname" />
        <input type = "submit" />
     </form>
  </body>
</html>

<?php
}


?>
