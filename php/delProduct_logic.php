<?php
session_start();
$my_account = $_SESSION["account"];
$my_password = $_SESSION["password"];

$Del_Number = $_POST['ProductUniqueNumber'];

include_once 'db_connect.php';

$sql2 = "select PHOTO from ProductInformation where ProductUniqueNumber = '$Del_Number'";
$stat = oci_parse($con, $sql2);
$ret = oci_execute($stat);

while(($row = oci_fetch_array($stat)) != false){
    $photoName = $Del_Number."_".$row['PHOTO'];
}

echo $photoName , "<br>";
$total_photoName = './img/'.$photoName;
echo $total_photoName, "<br>";
if(file_exists($total_photoName)){
    unlink($total_photoName);
    echo "img 폴더에서 파일삭제 성공";
}else{
    echo "img 폴더에서 파일삭제 실패";
}

$sql = "DELETE FROM ProductInformation WHERE ProductUniqueNumber = '$Del_Number'";
$stat = oci_parse($con, $sql);
$ret = oci_execute($stat);

if (!$ret) {
    echo "<br/>";
    echo "데이터 정보 삭제 실패";
    echo "<br/>";
}

$sql = "DELETE FROM ProductTransactionStatus WHERE ProductUniqueNumber = $Del_Number";
$stat = oci_parse($con, $sql);
$ret = oci_execute($stat);

if (!$ret) {
    echo "<br/>";
    echo "데이터 상태 삭제 실패";
    echo "<br/>";
}

$sql = "DELETE FROM ProductList WHERE ProductUniqueNumber = $Del_Number";
$stat = oci_parse($con, $sql);
$ret = oci_execute($stat);

if (!$ret) {
    echo "<br/>";
    echo "데이터 상태 삭제 실패";
    echo "<br/>";
}

oci_close($con);

echo "<script>alert('상품이 성공적으로 삭제되었습니다!');
        location.href='./mainpage.php'
        </script>";
?>