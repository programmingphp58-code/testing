<?php

$UniqueName  = "History";
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

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/plugins/table/datatable/dt-global_style.css">
<!-- END PAGE LEVEL STYLES -->



<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">


            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Refrence ID</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Payment Account</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php

                            $sql2 = "SELECT * FROM transactions WHERE internetid=:internetid ORDER BY trans_id DESC";
                            $wire5 = $conn->prepare($sql2);
                            $wire5->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);
                            $sn = 1;

                            while ($result4 = $wire5->fetch(PDO::FETCH_ASSOC)) {
                                $TransStatus = TransStatus($result4);
                                $TempBalance2 = $result4['amount'];
                            ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td>#<?= $result4['refrence_id']; ?></td>
                                    <?php
                                    if ($result4['transaction_type'] === 'credit') {
                                    ?>

                                        <td><span class="text-success">+<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></td>


                                    <?php
                                    } else {
                                    ?>
                                        <td><span class="text-danger">-<?= $currency ?><?php echo number_format($TempBalance2, 2, '.', ','); ?></span></td>


                                    <?php
                                    }
                                    ?>
                                    <td> <?= $result4['trans_type']; ?></td>
                                    <?php
                                    if ($result4['payment_account'] === 'current_account') {
                                    ?>

                                        <td><span class="badge badge-secondary inv-status"><?= $row['current_acctno'] ?> (Current Account)</span></td>


                                    <?php
                                    } else {
                                    ?>
                                        <td><span class="badge badge-dark inv-status"><?= $row['savings_acctno'] ?> (Savings Account)</span></td>


                                    <?php
                                    }
                                    ?>
                                    <td><?= $TransStatus ?></td>

                                    <td><span class="inv-date"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg> <?= $result4['created_at']; ?></span></td>
                                    <td>

                                        <a class="badge badge-info inv-status" href="./receipt.php?id=<?php echo $result4['trans_id']; ?>" aria-haspopup="true" aria-expanded="true">
                                            View Receipt </a>

                                    </td>
                                </tr>

                            <?php
                            }
                            ?>


                        </tbody>

                    </table>
                </div>
            </div>






        </div>


    </div>


    <script src="<?= $web_url ?>/ui/plugins/table/datatable/datatables.js"></script>
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 7
        });
    </script>


    <?php
    require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

    ?>