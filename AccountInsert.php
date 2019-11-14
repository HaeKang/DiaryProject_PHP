<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    include('dbcon.php');

    // Account table에 정보를 insert한다

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // POST로 값을 받아온다.
        $id=$_POST['id'];
        $context = $_POST['context'];
        $price = $_POST['price'];
        $date = $_POST['date'];
        $add_type = $_POST['add_type'];

        $real_price = (int)$price;

        if($add_type == '지출'){
          $real_price = $real_price * -1;
          echo $real_price;
        }


        if(empty($id)){
            $errMSG = "사용자가 없음";
        }
        else if(empty($price)){
          $errMSG = "가격을 입력하세요";
        }


        if(!isset($errMSG)) // 모두 입력이 되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 Account 테이블에 저장.
                $stmt = $con->prepare('INSERT INTO Account(id, context, price, date) VALUES(:id,:context,:price,:date)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':context', $context);
                $stmt->bindParam(':price', $real_price);
                $stmt->bindParam(':date', $date);

                if($stmt->execute())
                {
                    $successMSG = "추가 완성";
                }
                else
                {
                    $errMSG = "추가 에러";
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
                context: <input type = "text" name = "context" />
                price: <input type = "text" name = "price" />
                date : <input type = "text" name = "date" />
                type : <input type = "text" name = "add_type" />
                <input type = "submit" name = "submit" />
            </form>
       </body>
    </html>
<?php
}
?>
