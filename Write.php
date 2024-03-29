<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // post(다이어리)를 작성하는 php, 글은 하루에 한 번만 작성 가능하다

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // POST값들을 불러온다.
        $id=$_POST['id'];
        $nickname = $_POST['nickname'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $weather = $_POST['weather'];
        $privateString = $_POST['private'];
        $private = $privateString === 'true' ? true:false;

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
                // SQL문을 실행하여 데이터를 Post 테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO Post(id, nickname, title, date, content, weather, private)
                VALUES(:id, :nickname, :title, :date ,:content, :weather, :private)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nickname', $nickname);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':weather', $weather);
                $stmt->bindParam(':private', $private);

                if($stmt->execute())
                {
                    $successMSG = "글 추가 완성";
                    echo "글 추가 완성";
                }
                else
                {
                    $errMSG = "하루에 글은 한번만 쓸 수 있습니다.";
                    echo "하루에 글은 한번만 쓸 수 있습니다.";
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
                weather : <input type="text" name="weather"/>
                private : <input type="text" name="private"/>
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
