<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 쪽지를 보내는 php


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // POST값을 받아온다
        $send_id=$_POST['send_id'];
        $recv_id = $_POST['recv_id'];
        $content = $_POST['content'];
        $date = date("Y-m-d", time());


        if(empty($send_id) && empty($recv_id)){
            $errMSG = "error";
        }


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // note 테이블에 정보들을 insert한다.
                $stmt = $con->prepare('INSERT INTO Note(send_id, recv_id, content, send_date)
                VALUES(:send_id,:recv_id,:content,:send_date)');
                $stmt->bindParam(':send_id', $send_id);
                $stmt->bindParam(':recv_id', $recv_id);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':send_date', $date);

                if($stmt->execute())
                {
                    $successMSG = "쪽지를 보냈습니다.";
                }
                else
                {
                    $errMSG = "쪽지 보내기 error";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }

    }

?>

<?php
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( !$android )
    {
?>
    <html>
       <body>
            <form action="<?php $_PHP_SELF ?>" method="POST">
                send_nick: <input type = "text" name = "send_id" />
                recv_nick: <input type = "text" name = "recv_id" />
                content: <input type = "text" name = "content" />
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
