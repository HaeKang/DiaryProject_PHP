<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');

// 선택된 note의 idx에 해당하는 쪽지의 내용, 보낸이, 받은날짜를 받아옴

//POST 값을 읽어온다.
$idx=isset($_POST['idx']) ? $_POST['idx'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// 해당 idx에 해당하는 note의 정보를 불러온다.
$sql="select send_id, send_date, content from Note where idx='$idx'";
$stmt = $con->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() == 0){

}

else{

   $data = array();

   while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        array_push($data,
               array('send_id'=>$row["send_id"],
               'content'=>$row["content"],
               'date'=>$row["send_date"]
           ));

    }

    if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
    } else{
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("note"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
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
        쪽지번호: <input type = "text" name = "idx" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}

?>
