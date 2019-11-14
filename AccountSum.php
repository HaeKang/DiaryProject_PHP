<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// 그날 입력한 데이터의 총 sum 값을 나타낸다.

//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($id != "" ){
  // 해당 id가 date에 쓴 price들의 합을 구한다
   $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date'";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() == 0){

       echo "error";
   }
 else{

     $data = array();

       while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         $sum;
         extract($row);
         if($row["sum(price)"] == null || $row["sum(price)"] == 0){
           $sum = 0;
         } else{
           $sum = $row["sum(price)"];
         }
           array_push($data,
               array('sum'=>$sum
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
