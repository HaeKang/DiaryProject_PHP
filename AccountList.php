<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 그 날에 사용자가 입력한 Account list들을 불러온다

//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($id != "" ){
  // sql문으로 해당 id가 해당 date에 작성한 account list들을 불러온다.
   $sql="SELECT context, price, idx FROM Account WHERE id = '$id' and date='$date'";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() == 0){

       echo "error";
   }
 else{

     $data = array();

       while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

         extract($row);

           array_push($data,
               array('context'=>$row["context"],
               'price' => $row["price"],
               'idx' => $row["idx"]
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
   echo " error ";
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
        날짜: <input type = "text" name = "date" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}


?>
