<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 받은 쪽지를 삭제하는 php

    // POST값 받아옴
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    $idx = isset($_POST['idx']) ? $_POST['idx'] : '';


    // 해당 idx에 해당하는 쪽지를 삭제한다.
    $sql = ("DELETE FROM Note where idx = '$idx'");
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
            노트번호 : <input type = "text" name = "idx" />
            <input type = "submit" />
         </form>
      </body>
    </html>
    <?php
    }

  ?>
