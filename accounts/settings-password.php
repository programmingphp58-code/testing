<?php
$UniqueName  = "Manage Password";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

if (isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    if (empty($old_password)) {
        toast_alert('danger', 'Enter Old Password', 'Close');
    } elseif (empty($new_password) || empty($confirm_password)) {
        toast_alert('danger', 'Enter New Password & Confirm Password', 'Close');
    } else {

        $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
        $verification = password_verify($old_password, $row['acct_password']);

        if ($verification === false) {
            toast_alert("error", "Incorrect Old Password", "Close");
        } else if ($new_password !== $confirm_password) {
            toast_alert("error", "Confirm Password not matched", "Close");
        } else if ($new_password === $old_password) {
            toast_alert('error', 'New Password Matched with Old Password', 'Close');
        } else {
            $sql2 = "UPDATE accounts SET acct_password=:acct_password WHERE internetid =:internetid";
            $passwordUpdate = $conn->prepare($sql2);
            $passwordUpdate->execute([
                'acct_password' => $new_password2,
                'internetid' => $_SESSION['internetid']
            ]);



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

            $full_name = $row['firstname'] . " " . $row['lastname'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['website_address'];
            $user_email = $row['acct_email'];

            $message = $sendMail->PasswordMsg($full_name, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Password Change" . "-" . $APP_NAME;
            // $email_message->send_mail($user_email, $message, $subject);

            if (true) {
                toast_alert('success', 'Your Password Change Successfully !', 'Approved');
            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
    }
}



?>



<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="content">

        <div class="container-fluid">

            <div class="row layout-top-spacing">

                <div id="basic" class="col-lg-6 mx-auto">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4><?= $UniqueName ?></h4>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">
                            <form method="POST" enctype="multipart/form-data">

                                <label for="basic-url">Old Password</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" autocomplete="off" name="old_password" placeholder="Old Password" required>
                                </div>

                                <label for="basic-url">New Password</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" autocomplete="off" placeholder="New Password" name="new_password" required>
                                </div>


                                <label for="basic-url">Confirm New Password</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" id="phone_number" autocomplete="off" name="confirm_password" placeholder="Confirm New Password" required>
                                </div>




                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" type="submit" name="change_password" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Change Password</button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <br><br><br>
                </div>

            </div>

        </div>







        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>