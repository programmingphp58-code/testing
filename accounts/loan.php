<?php

$UniqueName  = "My Loans";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/header.php");
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

?>





<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">




            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">


                <div class="table-responsive">
                    <table class="table mb-4">
                        <caption>Loans history</caption>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Duration</th>
                                <th class="">Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql2 = "SELECT * FROM transactions WHERE internetid=:internetid AND trans_type='Loan' ORDER BY trans_id DESC";
                            $wire5 = $conn->prepare($sql2);
                            $wire5->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);
                            $sn = 1;

                            while ($result44 = $wire5->fetch(PDO::FETCH_ASSOC)) {

                                $TempBalance2 = $result44['amount'];



                            ?>
                                <tr>
                                    <td class="text-center"><?= $sn++ ?></td>
                                    <?php
                                    if ($result44['transaction_type'] == 'credit') {
                                    ?>

                                        <td><span class="text-success">+<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></td>


                                    <?php
                                    } else {
                                    ?>
                                        <td><span class="text-danger">-<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></td>


                                    <?php
                                    }
                                    ?>
                                    <td><?= $result44['loan_type']; ?></td>
                                    <td><?= $result44['duration']; ?></td>
                                    <td class=""><?= $result44['trans_status']; ?></td>
                                    <td><?= $result44['created_at']; ?></td>

                                </tr>
                            <?php

                            } ?>

                        </tbody>
                    </table>
                </div>


            </div>

        </div>


    </div>





    <?php
    require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

    ?>