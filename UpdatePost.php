<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 작성한 글을 수정하는 php

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // POST값 받아온다
        $title = $_POST['title'];
        $content = $_POST['content'];

        $privateString = $_POST['private'];
        $private = $privateString === 'true' ? true:false;

        $weather = $_POST['weather'];

        $date = date("Y-m-d",time());


        if(empty($title)){
            $errMSG = "title 입력하세요";
            echo "title 입력하세요";
        }
        else if(empty($content)){
          $errMSG = "내용을 입력하세요";
          echo "내용을 입력하세요";
        }


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // 글을 수정하는 update문 수행
                $stmt = $con->prepare("UPDATE Post
                                       SET title = '$title', content = '$content', weather = '$weather'
                                       WHERE date = '$date' ");


                if($stmt->execute())
                {
                    $successMSG = "글 수정 완료";
                    echo "글 수정 완료";
                }
                else
                {
                    $errMSG = "에러";
                    echo "에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }

    }

?>

<?php


	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( !$android )
    {
?>
    <html>
       <body>
            <form action="<?php $_PHP_SELF ?>" method="POST">
                id: <input type = "text" name = "id" />
                nickname: <input type = "text" name = "nickname" />
                title: <input type = "text" name = "title" />
                content: <input type="text" name="content" />
                private : <input type="text" name="private"/>
                weather : <input type="text" name="weather"/>
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
