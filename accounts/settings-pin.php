<?php
$UniqueName  = "Manage Pin";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['change_pin'])) {
    $current_pin = inputValidation($_POST['current_pin']);
    $new_pin = inputValidation($_POST['new_pin']);
    $confirm_pin = inputValidation($_POST['confirm_pin']);
    $verify_pin = $row['acct_pin'];

    if ($current_pin !== $verify_pin) {
        toast_alert('error', 'Invalid Old Pin');
    } else if ($new_pin !== $confirm_pin) {
        toast_alert('error', 'Confirm Pin not Matched');
    } else if ($new_pin === $verify_pin) {
        toast_alert('error', 'New Pin Matched with Old Pin');
    } else {
        $sql2 = "UPDATE accounts SET acct_pin=:acct_pin WHERE internetid =:internetid";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_pin' => $new_pin,
            'internetid' => $_SESSION['internetid']
        ]);

       

        if ($page['padiwise_sms'] == '1') {
            $messageText = "Alert: Pincode Changed";
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

        $message = $sendMail->PinMsg($full_name, $APP_NAME, $APP_URL, $SITE_ADDRESS);
        // User Email
        $subject = "Pin Change" . "-" . $APP_NAME;
        // $email_message->send_mail($user_email, $message, $subject);

        if (true) {
            toast_alert('success', 'Account Pin Change Successfully', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}
?>



<!--  BEGIN CONTENT PART  -->
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

                                <label for="basic-url">Old Pin</label>
                                <div class="input-group mb-4">
                                <input type="text" inputmode="numeric" pattern="[0-9]+"  maxlength="6" autocomplete="off" class="form-control" name="current_pin" autocomplete="off" placeholder="Old Pin" required>
                        </div>

                                <label for="basic-url">New Password</label>
                                <div class="input-group mb-4">
                                <input type="text" inputmode="numeric" pattern="[0-9]+"  maxlength="6" autocomplete="off" class="form-control" name="new_pin" autocomplete="off" placeholder="New Pin" required>
                         </div>


                                <label for="basic-url">Confirm New Password</label>
                                <div class="input-group mb-4">
                                <input type="text" inputmode="numeric" pattern="[0-9]+"  maxlength="6" autocomplete="off" class="form-control" name="confirm_pin" autocomplete="off" placeholder="Confirm New Pin" required>
                        </div>




                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" type="submit" name="change_pin" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Change Pin</button>
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