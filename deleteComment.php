<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // 입력된 comment를 삭제하는 php문

    // POST값 받아옴
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
    $comment = isset($_POST['comment_user']) ? $_POST['comment_user'] : '';

    // 해당 post_id의 글의 nickname이 작성한 comment를 삭제한다.
    $sql = ("DELETE FROM Comment where post_id = '$post_id' and nickname = '$nickname' and comment_user = '$comment'");
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
            닉네임: <input type = "text" name = "nickname" />
            내용 : <input type = "text" name = "comment_user" />
            포스트번호 : <input type = "text" name = "post_id" />
            <input type = "submit" />
         </form>
      </body>
    </html>
    <?php
    }

  ?>
