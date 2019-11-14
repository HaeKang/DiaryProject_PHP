<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 입력된 Account를 삭제하는 php문

    // POST값 받아옴
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    $idx = isset($_POST['idx']) ? $_POST['idx'] : '';

    $sql = ("DELETE FROM Account where idx = '$idx'");
    $stmt = $con->prepare($sql);
    $stmt->execute();

?>

<?php

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if (!$android){
    ?>

    <html>
      <body>
         <form action="<?php $_PHP_SELF ?>" method="POST">
            포스트번호 : <input type = "text" name = "idx" />
            <input type = "submit" />
         </form>
      </body>
    </html>
    <?php
    }

  ?>
