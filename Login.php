<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 회원 로그인하는 php

//POST 값을 읽어온다.
$id= isset($_POST['id']) ? $_POST['id'] : '';
$user_pw = isset($_POST['pw']) ? $_POST['pw'] : '';

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($id != "" ){  // id 입력값이 null이 아니라면

   $sql="select * from User where id='$id'";
   $stmt = $con->prepare($sql);
   $stmt->execute();



   if ($stmt->rowCount() == 0){
       echo "아이디를 다시 확인하세요";
   }

   else{
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     extract($result);

     $db_pw = $result['pw'];  // db에 저장된 pw (암호화된 비밀번호)

     // 비밀번호가 일치하다면
     if(password_verify($user_pw, $db_pw)){
       $data = array();

      array_push($data,
          array('id'=>$result["id"],
                'nickname'=>$result["nickname"]
             ));


             if (!$android) {
                 echo "<pre>";
                 print_r($data);
                 echo '</pre>';
             }
             else
             {
                 header('Content-Type: application/json; charset=utf8');
                 $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
                 echo $json;
             }
      }

      else{
           echo "비밀번호를 다시 확인하세요";
         }
       }
}

 else{
    echo "존재하지 않는 회원입니다";
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
        비밀번호: <input type = "text" name = "pw" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}


?>
