<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');


//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if ($nickname != "" ){

   $sql="select nickname,id from User where id='$id' ";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() == 0){   // 없는 회원일 때
       echo "아이디를 다시 확인하세요";

   } else {      // 회원이 있을 때

     $data = array();

     while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

       extract($row);

       array_push($data,
            array('nickname'=>$row["nickname"],
                  'id'=>$row["id"]
           ));


       }

       if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
       } else
       {
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
           echo $json;
       }
   }
}
else {
   echo "검색할 닉네임을 입력하세요 ";
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
