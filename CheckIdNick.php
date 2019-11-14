<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 회원가입시 id와 nickname 중복 체크를 하는 php파일

//POST 값을 읽어온다.
$state_check=isset($_POST['state_check']) ? $_POST['state_check'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';
$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// ID 중복을 확인하는 경우라면
if($state_check == "id"){
  $sql="select id from User where id='$id'";
  $stmt = $con->prepare($sql);
  $stmt->execute();

  // 아이디 사용 가능
  if ($stmt->rowCount() == 0){
    $data = array();
    array_push($data,
           array('id_check_state'=>"ok"
       ));
  } else{ // 아이디 사용 불가능
    $data = array();
    array_push($data,
           array('id_check_state'=>"no"
       ));
  }

  if (!$android) {
         echo "<pre>";
         print_r($data);
         echo '</pre>';
  } else{
         header('Content-Type: application/json; charset=utf8');
         $json = json_encode(array("stateIdNick"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
         echo $json;
     }

}

// 닉네임 중복을 확인하는 경우
elseif ($state_check == "nickname"){
  $sql="select nickname from User where nickname='$nickname'";
  $stmt = $con->prepare($sql);
  $stmt->execute();

  // 닉네임 사용 가능
  if ($stmt->rowCount() == 0){
    $data = array();
    array_push($data,
           array('nick_check_state'=>"ok"
       ));

  } else{ // 닉네임 사용 불가능
    $data = array();
    array_push($data,
           array('nick_check_state'=>"no"
       ));

  }

  if (!$android) {
         echo "<pre>";
         print_r($data);
         echo '</pre>';
  } else{
         header('Content-Type: application/json; charset=utf8');
         $json = json_encode(array("stateIdNick"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
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
        state_check: <input type = "text" name = "state_check" />
        id: <input type = "text" name = "id" />
        nickname: <input type = "text" name = "nickname" />
        <input type = "submit" />
     </form>
  </body>
</html>
<?php
}


?>
