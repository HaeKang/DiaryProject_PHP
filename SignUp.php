<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 회원가입하는 php

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // Post 값들을 불러옴
        $id=$_POST['id'];
        $nickname = $_POST['nickname'];
        $pw = $_POST['pw'];

        // 비밀번호 암호화 수행
        $encrypted_pw = password_hash($pw, PASSWORD_DEFAULT);
        $encrypted_pw = substr($encrypted_pw, 0, 60);

        if(empty($id)){
            $errMSG = "id 입력하세요";
        }
        else if(empty($nickname)){
          $errMSG = "닉네임을 입력하세요";
        }


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를  User 테이블에 저장합니다.
                $stmt = $con->prepare('INSERT INTO User(id, pw, nickname) VALUES(:id,:pw,:nickname)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':pw', $encrypted_pw);
                $stmt->bindParam(':nickname', $nickname);

                if($stmt->execute())
                {
                    $successMSG = "사용자 추가 완성";
                }
                else
                {
                    $errMSG = "사용자 추가 에러";
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
                id: <input type = "text" name = "id" />
                pw: <input type = "text" name = "pw" />
                nickname: <input type = "text" name = "nickname" />
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
