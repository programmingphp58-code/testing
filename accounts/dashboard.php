<?php
$UniqueName  = "Dashboard";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/header.php");
// if ($page['kyc_status'] == '1' and $row['kyc_status'] == '0') {
//     header("location:./pending-kyc.php");
//     exit;
// }


// if ($row['kyc_pending'] == '0') {
//     header("location:./account-verification.php");
//     exit;
// }


// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

if (@!$_SESSION['internetid']) {
    header("location:../login.php");
    die;
}
if (@!$_COOKIE['firstVisit']) {
    setcookie("firstVisit", "no", time() + 3600);
    toast_alert('success', 'Welcome Back ' . $fullName . " !", 'Access Granted');
}

unset($_SESSION['wire_transfer'], $_SESSION['dom_transfer']);

?>





<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <br>


        <?php
       // if ($temp_trans['trans_status'] == "pending") {
            if (is_array($temp_trans) && $temp_trans['trans_status'] == "pending") {

        ?>

            <div class="alert alert-icon-left alert-light-primary mb-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg data-dismiss="alert"> ... </svg></button>
                <svg> ... </svg>
                <strong>Alert!</strong> You have a pending wire transaction of <?= $currency ?><?php echo number_format($TempBalance, 2, '.', ','); ?>! <a href="transfer-pending.php" class="text-danger">Resume Transaction!</a>
            </div>


        <?php

        } else {


        ?>

        <?php
        }
        ?>






        <div class="row layout-top-spacing">




            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-account-invoice-three">

                    <div class="widget-heading" style="min-height: 180px; max-height: 200px; padding-bottom: 20px;">
                        <div class="wallet-usr-info">
                            <div class="usr-name">
                                <span><img src="<?= $web_url ?>/ui/assets/img/<?= $row['acct_image'] ?>" alt="admin-profile" class="img-fluid" style="width: 40px; height: 40px; border-radius: 50%;"> <?= $fullName ?> </span>
                            </div>
                            <div class="add">
                                <a href="./helpdesk.php"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg></span></a>
                            </div>
                        </div>
                        <div class="wallet-balance" style="margin-top: 30px;">
                            <p style="margin-bottom: 5px;">Balance</p>
                            <h5 class="" style="margin: 0;"><span class="w-currency"></span><?= $currency ?><?php echo number_format($TotalBalance, 2, '.', ','); ?></h5>
                        </div>

                       
                    </div>

                    <div class="widget-amount" style="margin-top: -30px; position: relative; z-index: 1;">

                        <div class="w-a-info funds-received">
                            <span>Inflow <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg></span><br>

                            <?php
                            $sql = "SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE transaction_type='credit' AND internetid=:internetid";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);

                            $total = $stmt->fetch(PDO::FETCH_NUM);
                            $Inflow = $total[0] ?? 0;
                            ?>
                            <span class="text-success"><?= $currency ?><?php echo number_format($Inflow, 2, '.', ','); ?></span>


                        </div>

                        <div class="w-a-info funds-spent">
                            <span>Outflow <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up">
                                    <polyline points="18 15 12 9 6 15"></polyline>
                                </svg></span><br>
                            <?php
                            $sql = "SELECT SUM(amount) FROM transactions WHERE transaction_type='debit' AND internetid=:internetid";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);

                            $total = $stmt->fetch(PDO::FETCH_NUM);
                            $Outflow = ($total && isset($total[0])) ? ($total[0] ?? 0) : 0;
                            ?>
                            <span class="text-danger">
    <?= $currency ?>
    <?php echo number_format($Outflow, 2, '.', ','); ?>
</span>
                           
                        </div>
                    </div>

                    <div class="widget-content" style="clear: both;">

                        <div class="invoice-list">

                            <div class="inv-detail">
                                <div class="info-detail-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <p style="margin: 0;">Loan Balance:</p>
                                    <p style="margin: 0;"><span class="bill-amount text-secondary"><?= $currency ?><?php echo number_format($LoanBalance, 2, '.', ','); ?></span></p>
                                </div>

                                <div class="info-detail-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <p style="margin: 0;">Savings Balance:</p>
                                    <p style="margin: 0;"><span class="bill-amount text-info"><?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></span></p>
                                </div>

                                <div class="info-detail-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <p style="margin: 0;">Current Balance:</p>
                                    <p style="margin: 0;"><span class="bill-amount text-info"><?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></span></p>
                                </div>

                                <div class="info-detail-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <p style="margin: 0;">Business Balance:</p>
                                    <p style="margin: 0;"><span class="bill-amount text-success"><?= $currency ?><?php echo number_format($BusinessBalance, 2, '.', ','); ?></span></p>
                                </div>

                                <?php if ($BusinessName): ?>
                                <div class="info-detail-2" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <p style="margin: 0; font-size: 12px;">Business Name:</p>
                                    <p style="margin: 0; font-size: 12px;"><span class="text-muted"><?= $BusinessName ?></span></p>
                                </div>
                                <?php endif; ?>

                            </div>

                            <div class="inv-action" style="margin-top: 15px;">
                                <a href="./history.php" class="btn btn-outline-primary view-details" style="margin-bottom: 8px;">View Details</a>
                                <a href="./my-account.php" class="btn btn-outline-primary pay-now">Account Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">Transactions</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
                                    <a class="dropdown-item" href="./history.php">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <?php

                        $sql2 = "SELECT * FROM transactions WHERE internetid=:internetid ORDER BY trans_id DESC LIMIT 6";
                        $wire5 = $conn->prepare($sql2);
                        $wire5->execute([
                            'internetid' => $_SESSION['internetid']
                        ]);
                        $sn = 1;

                        while ($result4 = $wire5->fetch(PDO::FETCH_ASSOC)) {
                            $TempBalance2 = $result4['amount'];
                        ?>

                            <?php
                            if ($result4['transaction_type'] === 'credit') {
                            ?>
                                <div class="transactions-list t-info">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-icon">
                                                <div class="avatar avatar-xl">
                                                    <span class="avatar-title">+</span>
                                                </div>
                                            </div>
                                            <div class="t-name">
                                                <h4><?= $result4['trans_type']; ?></h4>
                                                <p class="meta-date"><?= $result4['created_at']; ?></p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p><span>+<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></p>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            } else {
                            ?>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-icon">
                                                <div class="avatar avatar-xl">
                                                    <span class="avatar-title">-</span>
                                                </div>
                                            </div>
                                            <div class="t-name">
                                                <h4><?= $result4['trans_type']; ?></h4>
                                                <p class="meta-date"><?= $result4['created_at']; ?></p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-dec">
                                            <p><span>-<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></p>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>




                        <?php
                        }
                        ?>





                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-activity-four">

                    <div class="widget-heading">
                        <h5 class="">Recent Activities</h5>
                    </div>
                    

                    <div class="widget-content">

                        <div class="mt-container mx-auto">
                            <div class="timeline-line">

                                <?php

                                $sql2 = "SELECT * FROM activities WHERE internetid=:internetid ORDER BY id DESC";
                                $wire5 = $conn->prepare($sql2);
                                $wire5->execute([
                                    'internetid' => $_SESSION['internetid']
                                ]);
                                $sn = 1;

                                while ($result4 = $wire5->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                    <div class="item-timeline timeline-primary">
                                        <div class="t-dot" data-original-title="" title="">
                                        </div>
                                        <div class="t-text">
                                            <p><?= $result4['details'] ?></p>
                                            <span class="text-danger"><?= $result4['createdat'] ?? $result4['createdAt'] ?? date('Y-m-d H:i:s') ?></span>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>






                            </div>
                        </div>

                        <div class="tm-action-btn">
                           <a href="./activities.php"> <button class="btn"><span></span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg> View All</button></a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-header">
                            <div class="w-info">
                                <h6 class="value">Business Name</h6>
                            </div>
                        </div>

                        <div class="w-content">

                            <div class="w-info">
                                <p class="value">(<?= !empty($row['business_acctno']) ? $row['business_acctno'] : 'N/A' ?>)</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-header">
                            <div class="w-info">
                                <h6 class="value">Current Account</h6>
                            </div>
                        </div>

                        <div class="w-content">

                            <div class="w-info">
                                <p class="value">(<?= $row['current_acctno'] ?>)</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-header">
                            <div class="w-info">
                                <h6 class="value">Savings Account</h6>
                            </div>
                        </div>

                        <div class="w-content">

                            <div class="w-info">
                                <p class="value">(<?= $row['savings_acctno'] ?>)</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>



        </div>

    </div>



    <?php



    require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

    ?>