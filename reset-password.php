<?php


$UniqueName  = "Forgot Password";
require("auth/header2.php");
if (@$_SESSION['internetid']) {
    header("Location:./accounts/dashboard.php");
}

if (isset($_POST['send-link'])) {
    $email = inputValidation($_POST['email']);
    $log = "SELECT * FROM accounts WHERE acct_email =:email";
    $stmt = $conn->prepare($log);
    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $validAcct_email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($validAcct_email, FILTER_VALIDATE_EMAIL)) {
        toast_alert("error", "Invalid email address please type a valid email address!");
    } elseif ($user['acct_email'] == "") {
        toast_alert("error", "No user is registered with this email address!");
    } else {

        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d");

        $sql = "UPDATE accounts SET resettoken=:reset_token,resettokenexp=:date WHERE acct_email=:email";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'reset_token' => $reset_token,
            'date' => $date,
            'email' => $email
        ]);

        if (true) {


            if ($page['padiwise_sms'] == '1') {
                $messageText = "Alert: Password Reset";
                $recipient = $user['acct_phone'];

                $responseBody = send_bulk_sms(array(
                    'sender_name' => get_setting('display_name'),
                    'recipient' => $recipient,
                    'reference' => date('Y') . uniqid() . rand(1, 9),
                    'message' => $messageText
                ));
            }

            $full_name = $user['firstname'] . " " . $user['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['website_address'];
            $APP_NUMBER = WEB_PHONE;
            $APP_EMAIL = WEB_EMAIL;
            $user_email = $user['acct_email'];

            $message = $sendMail->ForgotMsg($full_name, $email, $reset_token, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Password Reset" . "-" . $APP_NAME;
            // $email_message->send_mail($user_email, $message, $subject);

            toast_alert("success", "Password reset link sent to email", "Thanks!");
        } else {
            toast_alert("error", "Sorry Something Went Wrong !");
        }
    }
}





?>




<div class="container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <img src="assets/images/logo/logo.png" alt="Dogwood State Bank" itemprop="url">
                      <br><br>

                    <p>Please type in the email address linked to your <?= $page['website_name'] ?> account to reset your password.</p>

                    <form class="text-left" method="POST" enctype="multipart/form-data">
                        <div class="form">



                            <div class="field-wrapper input mb-2">
                                <label for="password">Email Address</label>

                                <input type="email" maxlength="60" class="form-control" placeholder="example@gmail.com" name="email" />


                            </div><br>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" name="send-link">Reset Password</button>
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