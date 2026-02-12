<?php

$UniqueName  = "Resume International Transfer";
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

require($_SERVER['DOCUMENT_ROOT'] . "/configuration/Transfer/WireFunction.php");


if ($page['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}

if ($row['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
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
                                    <h4>Resume Transaction</h4>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="widget-content widget-content-area">
                            <form method="POST" enctype="multipart/form-data">
                                <label for="basic-url">Amount (Total Balance: <?= $currency ?><?php echo number_format($TotalBalance, 2, '.', ','); ?>)</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= $currency ?></span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" value="<?= $temp_trans['amount'] ?>" readonly aria-label="Amount (to the nearest dollar)">

                                    <input type="text" hidden value="<?= $page['wirefee'] ?>" name="fee">

                                    <input type="text" hidden value="<?= $row['internetid'] ?>" name="internetid">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Fee: <?= $currency ?><?= $page['wirefee'] ?></span>
                                    </div>
                                </div>

                                <label for="basic-url">Payment Account</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" name="payment_account">
                                        <option value="<?= $temp_trans['payment_account'] ?>">Select Payment Account</option>
                                        <option value="savings_account"><strong>(<?= $row['savings_acctno'] ?>)</strong> Savings: <?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></option>
                                        <option value="current_account"><strong>(<?= $row['current_acctno'] ?>)</strong> Current: <?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></option>
                                    </select>
                                </div>





                                <label for="basic-url">Account Number</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['account_number'] ?>" readonly class="form-control" placeholder="Account Number" name="account_number" aria-label="Username">
                                </div>

                                <label for="basic-url">Account Type</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['account_type'] ?>" class="form-control" readonly name="account_type">
                                </div>

                                <label for="basic-url">Account Name</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['account_name'] ?>" readonly class="form-control" placeholder="Account Name" name="account_name" aria-label="Username">
                                </div>

                                <label for="basic-url">Routine Number/ Bank Code</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['routine_number'] ?>" readonly class="form-control" placeholder="Routine Number/ Bank Code" name="routine_number" aria-label="Username">
                                </div>

                                <label for="basic-url">Bank Name</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['bank_name'] ?>" readonly class="form-control" placeholder="Bank Name" name="bank_name" aria-label="Username">
                                </div>


                                <label for="basic-url">Bank Country</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['bank_country'] ?>" class="form-control" readonly name="bank_country">

                                </div>






                                <label for="basic-url">Details</label>
                                <div class="input-group mb-4">
                                    <input type="text" value="<?= $temp_trans['description'] ?>" class="form-control" readonly name="description">

                                </div>



                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" name="wire-transfer" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Continue Transaction</button>
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