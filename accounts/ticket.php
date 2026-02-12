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





<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">




            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">


                <div class="table-responsive">
                    <table class="table mb-4">
                        <caption>List of all tickets</caption>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Ticket</th>
                                <th>Type</th>
                                <th class="">Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql2 = "SELECT * FROM ticket WHERE internetid=:internetid ORDER BY ticket_id DESC";
                            $wire5 = $conn->prepare($sql2);
                            $wire5->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);
                            $sn = 1;

                            while ($result44 = $wire5->fetch(PDO::FETCH_ASSOC)) {

                                $TickeStatus = TickeStatus($result44);
                                $TempBalance2 = $result44['amount'];



                            ?>
                                <tr>
                                    <td class="text-center"><?= $sn++ ?></td>
                                    <td class="text-primary"><?= $result44['ticket_message']; ?></td>
                                    <td><?= $result44['ticket_type']; ?></td>
                                    <td class=""><?= $TickeStatus ?></td>
                                    <td><?= $result44['createdAt']; ?></td>

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