<?php

$UniqueName  = "Lockscreen";
require("auth/header.php");

$fullName = $row['firstname'] . " " . $row['lastname'];
// if (@$_SESSION['internetid']) {
//   header("Location:./accounts/dashboard");
// }
unset($_SESSION['internetid']);

if (isset($_POST['pincodesubmit'])) {
    // Validate and process form submission
    $acct_password = inputValidation($_POST['acct_password']);

    // Initialize $row
    $row = null;

    // Check if $_SESSION['internetid'] is set
    if (isset($_SESSION['internetid'])) {
        // Prepare and execute SQL query to fetch user data
        $viesConn = "SELECT * FROM accounts WHERE internetid = :internetid";
        $stmt = $conn->prepare($viesConn);
        $stmt->execute([
            'internetid' => $_SESSION['internetid']
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Handle the case where $_SESSION['internetid'] is not set
        // You may want to redirect the user or display an error message
        exit("Session expired or not logged in");
    }

    // Check if user data fetched successfully
    if (!$row) {
        // Handle the case where no user data is found
        // You may want to redirect the user or display an error message
        exit("User data not found");
    }

    // Continue with your code...
    $details = "Session expired";
    // Insert activity log
    $stmt2 = $conn->prepare("INSERT INTO activities (internetid, details) VALUES (:internetid, :details)");
    $stmt2->execute([
        'internetid' => $_SESSION['internetid'],
        'details' => $details
    ]);

    // Check password validity
    $validPassword = password_verify($acct_password, $row['acct_password']);
    if ($validPassword === false) {
        toast_alert("error", "Invalid password");
    } else {
        if ($row['acct_status'] === 'hold') {
            toast_alert("error", "Account on Hold, Kindly contact support to activate your account");
        } else {
            // If password is valid, set session variable and redirect user
            $_SESSION['internetid'] = $row['internetid'];
            $_COOKIE['firstVisit'] = $row['internetid'];
            header("Location:./accounts/dashboard.php");
            exit(); // Redirect immediately after setting session variable
        }
    }
}
?>

<div class="form-container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <div class="d-flex user-meta">
                        <img src="<?= $web_url?>/assets/user/profile/<?= $row['acct_image'] ?>" class="usr-profile" alt="avatar">
                        <div class="">
                            <p class=""><?= $fullName ?></p>
                        </div>
                    </div>

                    <form class="text-left" method="POST" enctype="multipart/form-data">
                        <div class="form">

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input id="password" name="acct_password" type="password" required class="form-control" placeholder="Password">
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper toggle-pass">
                                    <p class="d-inline-block">Show Password</p>
                                    <label class="switch s-primary">
                                        <input type="checkbox" id="toggle-password" class="d-none">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" name="pincodesubmit">Unlock</button>
                                </div>

                            </div>

                        </div>
                    </form>
                    <p class="terms-conditions">© 2020 All Rights Reserved. <a href="/"><?= $page['website_name'] ?></a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image">
        </div>
    </div>
</div>



<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/popper.min.js"></script>
<script src="<?= $web_url ?>/ui/bootstrap/js/bootstrap.min.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $web_url ?>/ui/assets/js/authentication/form-1.js"></script>

</body>

</html>