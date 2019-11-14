<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbcon.php');

// 사용자가 입력한 plan들을 불러오는 php

//POST 값을 읽어온다.
$id=isset($_POST['id']) ? $_POST['id'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

// id가 작성한 user_plan을 불러온다.
$sql="select idx, date, content from user_plan where id='$id'";
$stmt = $con->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() == 0){

}

else{

   $data = array();

   while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        array_push($data,
               array('date'=>$row["date"],
               'content'=>$row["content"],
               'idx' => $row["idx"]
           ));

    }

    if (!$android) {
           echo "<pre>";
           print_r($data);
           echo '</pre>';
    } else{
           header('Content-Type: application/json; charset=utf8');
           $json = json_encode(array("plan"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
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
        id: <input type = "text" name = "id" />
        <input type = "submit" />
     </form>

  </body>
</html>
<?php
}

?>
