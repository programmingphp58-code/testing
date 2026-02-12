<?php

$UniqueName  = "Helpdesk";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headerplain.php");
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

        <div class="helpdesk container">

            <div class="helpdesk layout-spacing">

                <div class="hd-header-wrapper">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="">Helpdesk</h4>
                            <p class="">A knowledge base pgae for all your answers!</p>


                        </div>
                    </div>
                </div>

                <div class="hd-tab-section">
                    <div class="row">
                        <div class="col-md-12 mb-5 mt-5">

                            <div class="accordion" id="hd-statistics">
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM faqs");
                                $stmt->execute();
                                while ($faqs = $stmt->fetch()) {
                                ?>
                                    <div class="card">
                                        <div class="card-header" id="hd-statistics-<?= $faqs['faq_id'] ?>">
                                            <div class="mb-0">
                                                <div class="" data-toggle="collapse" role="navigation" data-target="#collapse-hd-statistics-<?= $faqs['faq_id'] ?>" aria-expanded="false" aria-controls="collapse-hd-statistics-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                                        <line x1="12" y1="17" x2="12" y2="17"></line>
                                                    </svg>
                                                    <?= $faqs['title'] ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="collapse-hd-statistics-<?= $faqs['faq_id'] ?>" class="collapse" aria-labelledby="hd-statistics-<?= $faqs['faq_id'] ?>" data-parent="#hd-statistics">
                                            <div class="card-body">
                                                <p><?= $faqs['content'] ?></p>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>


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