<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <!-- <p class="">Copyright © 2021 <a target="_blank" href="https://ofofonobs.com">Ofofonobs</a>, All rights reserved.</p> -->
    </div>
    <div class="footer-section f-section-2">
        <!-- <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg></p> -->
    </div>
</div>
</div>
<!--  END CONTENT PART  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/popper.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $web_url ?>/ui/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= $web_url ?>/ui/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>

<!-- Flag click handler -->
<script type="text/javascript">
    $('.translation-links a').click(function() {
        var lang = $(this).data('lang');
        var $frame = $('.goog-te-menu-frame:first');
        if (!$frame.size()) {
            alert("Error: Could not find Google translate frame.");
            return false;
        }
        $frame.contents().find('.goog-te-menu2-item span.text:contains(' + lang + ')').get(0).click();
        return false;
    });
</script>


<script src="<?= $web_url ?>/ui/assets/js/custom.js"></script>
<script src="<?= $web_url ?>/ui/plugins/table/datatable/datatables.js"></script>
<script src="<?= $web_url ?>/ui/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="<?= $web_url ?>/ui/assets/js/apps/invoice-list.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?= $web_url ?>/ui/plugins/apex/apexcharts.min.js"></script>
<script src="<?= $web_url ?>/ui/assets/js/dashboard/dash_1.js"></script>


<script src="<?= $web_url ?>/ui/plugins/highlight/highlight.pack.js"></script>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/scrollspyNav.js"></script>

<script src="<?= $web_url ?>/ui/assets/js/widgets/modules-widgets.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- <script src="<?= $web_url ?>/ui/assets/js/components/session-timeout/bootstrap-session-timeout.js"></script> -->
<!-- END PAGE LEVEL PLUGINS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<!-- <script src="<?= $web_url ?>/ui/assets/js/components/session-timeout/custom-bootstrap_session_timeout.js"></script> -->
<!--  END CUSTOM SCRIPTS FILE  -->




</body>

</html>