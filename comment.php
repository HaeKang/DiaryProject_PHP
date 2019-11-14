<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // post에 대한 comment를 넣는 php

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // POST값 받아옴
        $nickname = $_POST['nickname'];
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];
        $id = $_POST['id'];


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 Comment테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO Comment(post_id, nickname, comment_user, id) VALUES(:post_id,:nickname,:comment_user, :id)');
                $stmt->bindParam(':post_id', $post_id);
                $stmt->bindParam(':nickname', $nickname);
                $stmt->bindParam(':comment_user',$comment);
                $stmt->bindParam(':id', $id);

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
