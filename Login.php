<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');


//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$pw = isset($_POST['pw']) ? $_POST['pw'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($id != "" ){

   $sql="select * from User where id='$id' and pw='$pw'";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() == 0){

       echo "아이디와 패스워드를 다시 확인하세요";
   }
 else{

     $data = array();

       while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

         extract($row);

           array_push($data,
               array('id'=>$row["id"],
               'pw'=>$row["pw"],
               'nickname'=>$row["nickname"],
           ));

         }


       if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
       }else
       {
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
           echo $json;
       }
   }
}
else {
   echo "아이디를 입력하세요 ";
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
