<?php

$UniqueName  = "Resume Transactions";
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

?>







<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="action-btn layout-top-spacing mb-5">

        </div>



        <div class="row scrumboard" id="cancel-row">
            <div class="col-lg-12 layout-spacing">

                <div class="task-list-section">

                    <?php

                    // //RESUME PAGE TEMP TRANSACTION FETCH
                    $sql = "SELECT * FROM temp_dumps WHERE internetid =:internetid AND trans_status='pending' OR trans_type='Wire transfer' ORDER BY trans_id DESC LIMIT 2";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        'internetid' => $_SESSION['internetid']
                    ]);

                    $sn = 1;

                    while ($temp_trans2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $TempBalance2 = $temp_trans2['amount'];

                    ?>


                        <div data-section="s-new" class="task-list-container" data-connect="sorting">
                            <div class="connect-sorting">
                                <div class="task-container-header">
                                    <h6 class="s-heading" data-listTitle="In Progress">In Progress <span class="text-danger">#<?= $temp_trans2['trans_id'] ?></span></h6>
                                </div>

                                <div class="connect-sorting-content" data-sortable="true">

                                    <div data-draggable="true" class="card img-task" style="">
                                        <div class="card-body">


                                            <div class="task-header">
                                                <div class="">
                                                    <h4 class="" data-taskTitle="Creating a new Portfolio on Dribble"><?= $temp_trans2['trans_type'] ?> info <br> <br></h4>
                                                    <p>Amount: <?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?><br>
                                                        Bank Name: <?= $temp_trans2['bank_name'] ?><br>
                                                        Account No: <?= $temp_trans2['account_number'] ?><br>
                                                        Refrence ID: <?= $temp_trans2['refrence_id'] ?>



                                                    </p>
                                                </div>
                                            </div>

                                            <div class="task-body">

                                                <div class="task-bottom">
                                                    <div class="tb-section-1">
                                                        <span data-taskDate="08 Aug 2020"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                                            </svg> <?= $temp_trans['created_at'] ?></span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>




                                </div>

                                <div class="add-s-task">
                                    <a href="wiretransfer-pending.php" class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="16"></line>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg> Resume Transaction</a>
                                </div>
                                <br>

                                <div class="add-s-task">
                                    <a href="delete-pending.php?id=<?php echo $temp_trans2['refrence_id']; ?>" class="text-danger">Delete Transaction</a>
                                </div>

                            </div>
                        </div>

                    <?php
                    }
                    ?>





                    <div data-section="s-approved" class="task-list-container" data-connect="sorting">

                        <div class="connect-sorting">
                            <div class="task-container-header">
                                <h6 class="s-heading" data-listTitle="New">New Wire Transfer</h6>

                            </div>


                            <div class="connect-sorting-content" data-sortable="true">

                            </div>

                            <div class="add-s-task">
                                <a href="wire-transfer.php" class="addTask"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg> Create New</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
   
</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= $web_url ?>/ui/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/popper.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $web_url ?>/ui/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= $web_url ?>/ui/assets/js/app.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?= $web_url?>/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/ie11fix/fn.fix-padStart.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>