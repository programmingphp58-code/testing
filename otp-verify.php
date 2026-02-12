<?php

$UniqueName  = "OTP Code";
require("auth/header2.php");


if (@!$_SESSION['login']) {
  header("location:./login.php");
}
if (@$_SESSION['internetid']) {
  header("Location:./accounts/dashboard.php");
}
$viesConn = "SELECT * FROM accounts WHERE internetid = :internetid";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
  'internetid' => $_SESSION['login']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$fullName = $row['firstname'] . " " . $row['lastname'];
$internetid = $row['internetid'];


if (isset($_POST['pincodesubmit'])) {
  $pincodeVerified = $_POST['input'];
  $old_otp = $row['acct_otp'];

  
  if ($pincodeVerified !== $old_otp) {
    toast_alert('error', 'Invalid Code');
    // notify_alert('Invalid Account Pincode','danger','2000','Close');
  }
  if (empty($pincodeVerified)) {
    toast_alert('error', 'Enter Your Pincode');
    // notify_alert('Please Enter Your Pincode','danger','2000','Close');

  }
  if ($pincodeVerified === $old_otp) {
    //session_start();
 
    if ($row['phoneverify'] == '0') {
                     
      
         $code = $row['acct_otp'];
      
         $messageText = "Kindly use ".$code." as OTP";
         $recipient = $row['acct_phone'];
         $sendEerID = "Auth";

         $responseBody = send_bulk_sms(array(
             'sender_name' => $sendEerID,
             'recipient' => $recipient,
             'reference' => date('Y') . uniqid() . rand(1, 9),
             'message' => $messageText
         ));
     }

 
      

    $_SESSION['internetid'] = $internetid;
    $_COOKIE['firstVisit'] = $internetid;
    header("Location:./accounts/dashboard.php");
  }
}
?>


<div class="container">
  <div class="form-form">
    <div class="form-form-wrap">
      <div class="form-container">
        <div class="form-content">

          <div class="d-flex user-meta">
            <img src="<?= $web_url?>/assets/user/profile/<?= $row['acct_image'] ?>" class="usr-profile" alt="avatar">
            <div class="">
              <p class=""><?= $fullName ?></p>
            </div>
          </div>

          <form class="text-left" method="POST" enctype="multipart/form-data">
            <div class="form">
              <div id="password-field" class="field-wrapper input mb-2">
                <div class="d-flex justify-content-between">
                  <label for="password">OTP CODE</label>
                  <a href="./signout" class="forgot-pass-link">Sign out?</a>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <input id="password" name="input" type="password" class="form-control" placeholder="******" required maxlength="6">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </div>
              <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                  <button type="submit" class="btn btn-primary" name="pincodesubmit">Unlock</button>
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