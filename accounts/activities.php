<?php

$UniqueName  = "Last 50 Activities";
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


            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Internet ID</th>
                                <th>Information</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql2 = "SELECT * FROM activities WHERE internetid=:internetid ORDER BY id DESC LIMIT 50";
                            $wire5 = $conn->prepare($sql2);
                            $wire5->execute([
                                'internetid' => $_SESSION['internetid']
                            ]);
                            $sn = 1;

                            while ($result4 = $wire5->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $result4['internetid'] ?></td>
                                    <td><?= $result4['details'] ?></td>
                                    <td><?= $result4['createdAt'] ?></td>

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


</div>





<?php
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

?>