<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');

// Pie차트를 위한 지출 항목에 대한 context별 sum 값을 얻는다

//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
$data = array();

if ($id != "" ){

   $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date' group by context having context='음식' ";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() != 0){
     while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
         extract($row);

         // 수입인 경우는 pie차트에서 따지지 않기에 0으로 취급
         if($row["sum(price)"] == null  || $row["sum(price)"] >= 0){
           $result_sum = 0;
         }else{
           $result_sum = $row["sum(price)"] * -1; // pie차트에 넣기 위해서는 양수로 바꿔준다
         }

         array_push($data,
             array('sum_food'=>$result_sum
            ));
          }
    } else{ // 만약 입력이 안되어있다면 pie 차트 오류를 막기위해 0으로 넣어준다.
      array_push($data,
          array('sum_food'=>"0"
         ));
    }

    $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date' group by context having context='도서' ";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() != 0){
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);

          if($row["sum(price)"] == null || $row["sum(price)"] >= 0){
            $result_sum = 0;
          }else{
            $result_sum = $row["sum(price)"] * -1;
          }

          array_push($data,
              array('sum_book'=>$result_sum
             )
            );
           }
     }else{ // 만약 입력이 안되어있다면 pie 차트 오류를 막기위해 0으로 넣어준다.
       array_push($data,
           array('sum_book'=>"0"
          ));
     }

    $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date' group by context having context='기타' ";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() != 0){
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);

          if($row["sum(price)"] == null || $row["sum(price)"] >= 0){
            $result_sum = 0;
          }else {
            $result_sum = $row["sum(price)"] * -1;
          }

          array_push($data,
              array('sum_else'=>$result_sum
             ));
           }
     }else{ // 만약 입력이 안되어있다면 pie 차트 오류를 막기위해 0으로 넣어준다.
       array_push($data,
           array('sum_else'=>"0"
          ));
     }

     $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date' group by context having context='의류' ";
     $stmt = $con->prepare($sql);
     $stmt->execute();

     if ($stmt->rowCount() != 0){
       while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
           extract($row);

           if($row["sum(price)"] == null || $row["sum(price)"] >= 0){
             $result_sum = 0;
           }else {
             $result_sum = $row["sum(price)"] * -1;
           }

           array_push($data,
               array('sum_cloth'=>$result_sum
              ));
            }
      }else{ // 만약 입력이 안되어있다면 pie 차트 오류를 막기위해 0으로 넣어준다.
        array_push($data,
            array('sum_cloth'=>"0"
           ));
      }

      $sql="SELECT sum(price) FROM Account WHERE id = '$id' and date='$date' group by context having context='교통' ";
      $stmt = $con->prepare($sql);
      $stmt->execute();

      if ($stmt->rowCount() != 0){
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            if($row["sum(price)"] == null || $row["sum(price)"] >= 0){
              $result_sum = 0;
            }else {
              $result_sum = $row["sum(price)"] * -1;
            }

            array_push($data,
                array('sum_traffic'=>$result_sum
               ));
             }
       }else{ // 만약 입력이 안되어있다면 pie 차트 오류를 막기위해 0으로 넣어준다.
         array_push($data,
             array('sum_traffic'=>"0"
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
