<?php

$UniqueName  = "New Ticket";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");
// if ($page['kyc_status'] == '1' and $row['kyc_status'] == '0') {
//     header("location:./pending-kyc.php");
//     exit;
// }

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
// Other scripts Available

if (@!$_SESSION['internetid']) {
    header("location:../login.php");
    die;
}


if (isset($_POST['ticket_submit'])) {
    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);

    $internetid = inputValidation($row['internetid']);
    $ticket_type = inputValidation($_POST['ticket_type']);
    $ticket_message = inputValidation($_POST['description']);



    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect PINCODE');
    } else {


        if (true) {


            if ($page['padiwise_sms'] == '1') {
                $messageText = "New Loan Request";
                $recipient = $row['acct_phone'];

                $responseBody = send_bulk_sms(array(
                    'sender_name' => get_setting('display_name'),
                    'recipient' => $recipient,
                    'reference' => date('Y') . uniqid() . rand(1, 9),
                    'message' => $messageText
                ));
            }

            $sql = "INSERT INTO ticket (internetid,ticket_message,ticket_type,image) VALUES(:internetid,:ticket_message,:ticket_type,:image)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'internetid' => $internetid,
                'ticket_message' => $ticket_message,
                'ticket_type' => $ticket_type,
                'image' => $n,
            ]);

            $details = "New Ticket";
            $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
            $stmt2->execute([
                'internetid' => $_SESSION['internetid'],
                'details' => $details
            ]);



            if (true) {

                toast_alert("success", "Your request is been reviewed", "Thank You");
            } else {
                toast_alert("error", "Sorry Error Occured Contact Support");
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


                                <label for="basic-url">Ticket Type</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="ticket_type">
                                        <option>Select Loan Type</option>
                                        <option value="My Account">My Account</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Security">Security</option>
                                    </select>
                                </div>










                                <label for="basic-url">More Information</label>
                                <div class="input-group mb-4">
                                    <textarea class="form-control" aria-label="With textarea" rows="6" required name="description" placeholder="Well detailed"></textarea>
                                </div>


                                <label for="basic-url">Account Pincode</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="******" name="pin">
                                </div>



                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" name="ticket_submit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Create New Ticket</button>
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