<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// account 의 context 별 sum 값을 얻어온다

//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
$data = array();

if ($id != "" ){
  // 항목 별 총액을 구한다.
   $sql="SELECT sum(price),context FROM Account WHERE id = '$id' and date='$date' group by(context) ";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() != 0){
     while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         array_push($data,
             array('price'=>$row["sum(price)"],
             'context' => $row["context"]
            ));
          }
    }

    else{
      echo "error";
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
