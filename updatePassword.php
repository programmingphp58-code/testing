<?php


$UniqueName  = "New Password";
require_once("auth/header2.php");
if (@$_SESSION['internetid']) {
    header("Location:./accounts/dashboard.php");
}

if (isset($_GET['email']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/kolkata');
    $date = date("Y-m-d");
    $email = $_GET['email'];
    $reset_token = $_GET['reset_token'];

    $log2 = "SELECT * FROM accounts WHERE acct_email=:email";
    $stmt = $conn->prepare($log2);
    $stmt->execute([
        'email' => $email
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    toast_alert("error", "Sorry Something Went Wrong !");
}

if (isset($_POST['update'])) {
    $new_password = inputValidation($_POST['new_password']);
    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);

    // if ($new_password < 6) {
    //     toast_alert("error", "Your password must be atleast 6 characterss!");
    // } else{


    $sql2 = "UPDATE accounts SET acct_password=:acct_password,resettoken=:resettoken,resettokenexp=:resettokenexp WHERE acct_email=:email";
    $passwordUpdate = $conn->prepare($sql2);
    $passwordUpdate->execute([
        'acct_password' => $new_password2,
        'resettoken' => NULL,
        'resettokenexp' => NULL,
        'email' => $email
    ]);

    if (true) {

        if ($page['padiwise_sms'] == '1') {
            $messageText = "Security Alert: Password Changed";
            $recipient = $row['acct_phone'];

            $responseBody = send_bulk_sms(array(
                'sender_name' => get_setting('display_name'),
                'recipient' => $recipient,
                'reference' => date('Y') . uniqid() . rand(1, 9),
                'message' => $messageText
            ));
        }

        $msg1 = "
            <div class='alert alert-warning'>
            
            <script type='text/javascript'>
                 
                    function Redirect() {
                    window.location='./login.php';
                    }
                    document.write ('');
                    setTimeout('Redirect()', 4000);
                 
                    </script>
                    
            <center><img src='./ui/loading.gif' width='180px'  /></center>
            
            
            <center>	<strong style='color:black;'>Your Password Change Successfully, Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
    } else {
        toast_alert("error", "Sorry Something Went Wrong !");
    }
}
// }


?>





<div class="container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <div class="d-flex user-meta">
                        <img src="<?= $web_url?>/assets/user/profile/<?= $row['acct_image'] ?>" class="usr-profile" alt="avatar">
                        <div class="">
                            <p class="">Please choose a strong and easy password.</p>
                        </div>
                    </div>

                    <?php if (isset($msg1)) echo $msg1; ?>


                    <form class="text-left" method="POST" enctype="multipart/form-data">
                        <div class="form">



                            <div class="field-wrapper input mb-2">
                                <label for="password">Enter New Password</label>

                                <input type="text" name="new_password" minlength="6" maxlength="60" class="form-control" placeholder="Create New Password" />
                                <input type="hidden" name="email" class="form-control" value='.$email.'>


                            </div><br>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" name="update">Update Password</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>




<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="../ui/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="../ui/bootstrap/js/popper.min.js"></script>
<script src="../ui/bootstrap/js/bootstrap.min.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="../ui/assets/js/authentication/form-2.js"></script>

</body>

</html>