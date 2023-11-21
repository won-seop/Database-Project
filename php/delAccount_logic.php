<?php
session_start();
$my_account = $_SESSION["account"];
$my_password = $_SESSION["password"];

$db = '(DESCRIPTION =(ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = 203.249.87.57)(PORT = 1521)))(CONNECT_DATA =(SID = orcl)))';
$con = oci_connect("DBA2022G3", "test1234", $db);

// 탈퇴한 회원 정보, 올린 물품 삭제
$sql1 = "UPDATE ProductTransactionStatus set buyer = '' where buyer = '$my_account'";

$sql2 = "UPDATE ProductList set account = '' where account = '$my_account'";

$sql3 = "DELETE FROM MemberInformation WHERE MemberInformation.account = '$my_account'";

$ret1 = oci_execute(oci_parse($con, $sql1));
$ret2 = oci_execute(oci_parse($con, $sql2));
$ret3 = oci_execute(oci_parse($con, $sql3));

if ($ret1 && $ret2 && $ret3) {
    oci_commit($con);
    oci_close($con);
    session_destroy();
    echo "<script>alert('계정이 성공적으로 삭제되었습니다!');
        location.href='./login_and_createAccount.php'
        </script>";
} else {
    echo "Error.";
}
?>