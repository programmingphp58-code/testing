<?php

$UniqueName  = "Deleting";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

$id = $_GET['id'];

$sql = "SELECT * FROM transactions LEFT JOIN accounts ON transactions.internetid = accounts.internetid WHERE refrence_id ='$id'";
$data = $conn->prepare($sql);
$data->execute(['id' => $id]);

$row = $data->fetch(PDO::FETCH_ASSOC);


$sql = "DELETE FROM transactions WHERE transactions.refrence_id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'id' => $id
]);



if (true) {

    $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./loan-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Deleted, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";

    // toast_alert('success','Deleted Successfully','Deleted');
} else {
    toast_alert('danger', 'Sorry Something Went Wrong', 'Error');
}

//header('Location:./loan-trans');

?>


<!-- Ofofonobs Developer WhatsAPP +2348114313795 -->

<div class="row">
    <?php if (isset($msg1)) echo $msg1; ?>
</div>