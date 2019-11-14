<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 사용자가 쓴 글 목록만 불러오는 php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// POST값을 받아온다
$id=isset($_POST['id']) ? $_POST['id'] : '';
$private=isset($_POST['private']) ? $_POST['private'] : '';


if($private != ""){
  // 비공개 글만 불러옴
  $sql="select nickname,post_id,title,date from Post where id='$id' and private = '$private' ";
  $stmt = $con->prepare($sql);
  $stmt->execute();

} else{
  // 모든 글을 불러옴
  $sql="select nickname,post_id,title,date from Post where id='$id' ";
  $stmt = $con->prepare($sql);
  $stmt->execute();

}


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
                  'date' => $row["date"]
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
        아이디: <input type = "text" name = "id" />
        공개상태: <input type = "text" name = "private" />
        <input type = "submit" />
     </form>
  </body>
</html>

<?php
}


?>
