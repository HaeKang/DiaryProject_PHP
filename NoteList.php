<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');

// 사용자가 받은 쪽지 목록들 불러오는 php

//POST 값을 읽어온다.
$recv_id = isset($_POST['recv_id']) ? $_POST['recv_id'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// recv_id(받는이)에 해당하는 note 정보들을 불러온다.
$sql="select send_id, content, send_date, idx from Note where recv_id='$recv_id'";
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
               'date'=>$row["send_date"],
               'content'=>$row["content"],
               'idx' => $row['idx']
           ));

    }


    if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
    } else{
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("notelist"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
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
        글번호: <input type = "text" name = "recv_nick" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}

?>
