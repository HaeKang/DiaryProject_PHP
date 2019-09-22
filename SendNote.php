<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $send_nick=$_POST['send_nick'];
        $recv_nick = $_POST['recv_nick'];
        $content = $_POST['content'];
        $date = date("Y-m-d", time());
        $recv_check = false;


        if(empty($send_nick) && empty($recv_nick)){
            $errMSG = "error";
        }


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{

                $stmt = $con->prepare('INSERT INTO send_note(send_nick, recv_nick, content, send_date, recv_check)
                VALUES(:send_nick,:recv_nick,:content,:send_date, :recv_check)');
                $stmt->bindParam(':send_nick', $send_nick);
                $stmt->bindParam(':recv_nick', $recv_nick);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':send_date', $date);
                $stmt->bindParam(':recv_check', $recv_check);

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
                send_nick: <input type = "text" name = "send_nick" />
                recv_nick: <input type = "text" name = "recv_nick" />
                content: <input type = "text" name = "content" />
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
