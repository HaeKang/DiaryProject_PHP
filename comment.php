<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $nickname = $_POST['nickname'];
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];



        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 person 테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO Comment(post_id, nickname, comment_user) VALUES(:post_id,:nickname,:comment_user)');
                $stmt->bindParam(':post_id', $post_id);
                $stmt->bindParam(':nickname', $nickname);
                $stmt->bindParam(':comment_user',$comment);


                if($stmt->execute())
                {
                    $successMSG = "댓글 추가 완성";
                }
                else
                {
                    $errMSG = "댓글 추가 에러";
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

?>
