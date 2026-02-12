<?php
$UniqueName  = "Secure Login";
require_once("auth/header.php");

if (@$_SESSION['internetid']) {
    header("Location:./accounts/dashboard.php");
}


if (isset($_POST['acct_login'])) {
    $internetid = inputValidation($_POST['login']);
    // $internetid = inputValidation($_POST['internetid']);
    $acct_password = inputValidation($_POST['acct_password']);
    $log = "SELECT * FROM accounts WHERE internetid='$internetid' OR acct_email = '$internetid'";
    $stmt = $conn->prepare($log);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        toast_alert("error", "Invalid login details");
    } else {
        $validPassword = password_verify($acct_password, $user['acct_password']);
        if ($validPassword === false) {
            toast_alert("error", "Invalid login details");
        } else {
            // if ($user['acct_status'] === 'hold') {
            //     toast_alert("error", "Account on Hold, Kindly contact support to activate your account");
            // } else {
                if (true) {

                    //IP LOGIN DETAILS - Made non-critical for faster login
                    $internetid = $user['internetid'];
                    
                    // Log activity first (more important than audit)
                    $details = "user login on";
                    try {
                        $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
                        $stmt2->execute([
                            'internetid' => $internetid,
                            'details' => $details
                        ]);
                    } catch (Exception $e) {
                        // Non-critical, just log error
                        error_log("Activity log failed: " . $e->getMessage());
                    }
                    
                    // Audit log - can be done async or skipped for speed
                    // Commenting out to improve login performance
                    /*
                    $device = $_SERVER['HTTP_USER_AGENT'];
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    $nowDate = date('Y-m-d H:i:s');
                    $stmt = $conn->prepare("INSERT INTO audit_logs (internetid,device,ipAddress,datenow) VALUES(:internetid,:device,:ipAddress,:datenow)");
                    $stmt->execute([
                        'internetid' => $internetid,
                        'device' => $device,
                        'ipAddress' => $ipAddress,
                        'datenow' => $nowDate
                    ]);
                    */

                    if ($page['padiwise_sms'] == '1') {
                        $messageText = "New Login Notification";
                        $recipient = $user['acct_phone'];

                        $responseBody = send_bulk_sms(array(
                            'sender_name' => get_setting('display_name'),
                            'recipient' => $recipient,
                            'reference' => date('Y') . uniqid() . rand(1, 9),
                            'message' => $messageText
                        ));
                    }


                    if($page['otp_code'] == "1"){


                        $acct_otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                        $sql =  "UPDATE accounts SET acct_otp=:acct_otp WHERE internetid=:internetid";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                           'acct_otp'=>$acct_otp,
                            'internetid' => $internetid
                        ]);



                              
                           

                        $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['website_address'];
                    $APP_NUMBER = WEB_PHONE;
                    $APP_EMAIL = WEB_EMAIL;
                    $user_email = $user['acct_email'];
                    
                    // Email sending disabled for performance - takes 3-5 seconds
                    // TODO: Send emails async via background job/queue
                    /*
                    $message = $sendMail->OtpLoginMsg($full_name, $acct_otp, $APP_NAME, $APP_NUMBER, $APP_EMAIL, $APP_URL, $SITE_ADDRESS);
                    // User Email
                    $subject = "OTP CODE" . "-" . $APP_NAME;
                    // $email_message->send_mail($user_email, $message, $subject);
                    */

                    $_SESSION['login'] = $user['internetid'];
                    header("Location:./otp-verify.php");
                    exit;


                    } else {

                        // Email sending disabled for performance - takes 3-5 seconds
                        // TODO: Send emails async via background job/queue
                        /*
                        $full_name = $user['firstname'] . " " . $user['lastname'];
                    $APP_NAME = WEB_TITLE;
                    $APP_URL = WEB_URL;
                    $SITE_ADDRESS = $page['website_address'];
                    $APP_NUMBER = WEB_PHONE;
                    $APP_EMAIL = WEB_EMAIL;
                    $user_email = $user['acct_email'];
                    
                    $message = $sendMail->LoginMsg($full_name, $APP_NAME, $APP_NUMBER, $APP_EMAIL, $APP_URL, $SITE_ADDRESS);
                    // User Email
                    $subject = "Login Notification" . "-" . $APP_NAME;
                    $email_message->send_mail($user_email, $message, $subject);
                    */

                    $_SESSION['login'] = $user['internetid'];
                    header("Location:./pin.php");
                    exit;
                     
               
                    }

                    

                    
                }
            }
        }
    }
// }



?>

<div class="form-container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                      <img src="assets/images/logo/logo.png" alt="Dogwood State Bank" itemprop="url">
                      <br><br>

                    <h1 class="">Log In to <a href="/"><span class="brand-name" style="color: #9d7a3e;"><?= $page['website_name'] ?></span></a></h1>
                    <p class="signup-link">New Here? <a href="./get-started.php" style="color: #617a87;">Create an account</a></p>
                    <form class="text-left" method="POST" enctype="multipart/form-data">
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input id="username" name="login" type="text" class="form-control" placeholder="Internet ID">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input id="password" name="acct_password" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper toggle-pass">
                                    <p class="d-inline-block">Show Password</p>
                                    <label class="switch s-primary">
                                        <input type="checkbox" id="toggle-password" class="d-none">
                                        <span class="slider round"></span>
                                    </label>
                                </div>


                            </div>

                            <br>

                            <center> <button type="submit" class="btn btn-primary btn-block mb-4 mr-2" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" name="acct_login">ACCESS ACCOUNT</button></center>


                            <div class="field-wrapper text-center keep-logged-in">
                                <div class="n-chk new-checkbox checkbox-outline-primary">
                                    <label style="color: #617a87;" class="new-control new-checkbox checkbox-outline-primary">
                                        <input type="checkbox" class="new-control-input">
                                        <span class="new-control-indicator"></span>Keep me logged in
                                    </label>
                                </div>
                            </div>


                            <div class="field-wrapper">
                                <a href="reset-password.php" class="forgot-pass-link" style="color: #617a87;">Forgot Password?</a>
                            </div>

                        </div>
                    </form>
                    <p class="terms-conditions">© 2024 All Rights Reserved. <a href="/" style="color: #617a87;"><?= $page['website_name'] ?></a></p>

                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div>
            <img src="assets/images/Dogwood.png" style="height: 800px;">
        </div>
    </div>
</div>


<?php

require_once("auth/footer.php");

?>