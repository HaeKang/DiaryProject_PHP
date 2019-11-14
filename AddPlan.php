<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 사용자의 일정을 user_plan 테이블에 입력하는 곳

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

      // POST값 받아옴
        $id=$_POST['id'];
        $date = $_POST['date'];
        $content = $_POST['content'];

        if(empty($content)){
            $errMSG = "일정을 입력하세요";
            echo $errMSG;
        }

        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 user_plan 테이블에 insert한다
                $stmt = $con->prepare('INSERT INTO user_plan(id, date, content)
                VALUES(:id, :date, :content)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':content', $content);


                if($stmt->execute())
                {
                    $successMSG = "일정추가완료";
                    echo "일정추가완료";
                }
                else
                {
                    $errMSG = "error";
                    echo "error";
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
                date: <input type = "text" name = "date" />
                content: <input type = "text" name = "content" />

                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
