<?php

$UniqueName  = "Self Transfer";
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

if ($page['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}

if ($row['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}


require($_SERVER['DOCUMENT_ROOT'] . "/configuration/Transfer/SelfFunction.php");
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

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="widget-content widget-content-area">
                            <form method="POST" enctype="multipart/form-data">
                                <label for="basic-url">Amount</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= $currency ?></span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" required aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Fee: <?= $currency ?><?= $page['selffee'] ?></span>
                                    </div>


                                    <input type="text" hidden value="<?= $row['internetid'] ?>" name="internetid">

                                </div>

                                <label for="basic-url">From Account</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="payment_account_from">
                                        <option>Select Payment Account</option>
                                        <option value="savings_account"><strong>(<?= $row['savings_acctno'] ?>)</strong> Savings: <?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></option>
                                        <option value="current_account"><strong>(<?= $row['current_acctno'] ?>)</strong> Current: <?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></option>
                                        <option value="business_account"><strong>(<?= $row['business_acctno'] ?? 'N/A' ?>)</strong> Business: <?= $currency ?><?php echo number_format($BusinessBalance, 2, '.', ','); ?></option>
                                    </select>
                                </div>


                                <label for="basic-url">To Account</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="payment_account">
                                        <option>Select Payment Account</option>
                                        <option value="savings_account">My Savings Account: <strong>(<?= $row['savings_acctno'] ?>)</strong> </option>
                                        <option value="current_account">My Current Account: <strong>(<?= $row['current_acctno'] ?>)</strong></option>
                                        <option value="business_account">My Business Account: <strong>(<?= $row['business_acctno'] ?? 'N/A' ?>)</strong></option>
                                    </select>
                                </div>

                                <label for="basic-url">Account Pincode</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="******" name="pin">
                                </div>








                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" name="Self_submit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Make Transfer</button>
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