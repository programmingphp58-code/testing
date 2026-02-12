<?php
$UniqueName  = "Open an Account";
include "auth/header2.php";

if (@$_SESSION['internetid']) {
    header("Location:./accounts/dashboard.php");
}

//   // force user to use pc
//   function isMobileDevice() {
//     return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
// |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
// , $_SERVER["HTTP_USER_AGENT"]);
// }

if (isset($_POST['regSubmit'])) {
    $internetid = "1202" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $current_acctno = "36378" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $savings_acctno = "67392" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $business_acctno = "89254" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_status = "active";
    $acct_email = $_POST['acct_email'];
    $acct_phone = $_POST['acct_phone'];
    $acct_password = $_POST['acct_password'];
    $confirmPassword = $_POST['confirm_password'];
    $acct_pin = $_POST['acct_pin'];
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : '';



    if ($acct_password !== $confirmPassword) {
        toast_alert('error', 'Your password do not matched');
   //  } else if ($acct_password < 6) {
    //     toast_alert('error', 'Your password must be atleast 6 characterss!');
    } else if (!filter_var($acct_email,FILTER_VALIDATE_EMAIL)) {
        toast_alert('error', 'You must enter a valid email!');
    } else {
        //checking exiting email
        $usersVerified = "SELECT * FROM accounts WHERE acct_email=:acct_email or acct_phone=:acct_phone";
        $stmt = $conn->prepare($usersVerified);
        $stmt->execute([
            'acct_email' => $acct_email,
            'acct_phone' => $acct_phone
        ]);

        if ($stmt->rowCount() > 0) {
            toast_alert('error', 'Email or Phone Number Already Exit');
        } else {

            //INSERT INTO DATABASE
            $registered = "INSERT INTO accounts (current_acctno,savings_acctno,business_acctno,business_name,firstname,lastname,acct_email,acct_password,internetid,acct_status,acct_phone,acct_pin) VALUES(:current_acctno,:savings_acctno,:business_acctno,:business_name,:firstname,:lastname,:acct_email,:acct_password,:internetid,:acct_status,:acct_phone,:acct_pin)";
            $reg = $conn->prepare($registered);
            $reg->execute([
                'current_acctno' => $current_acctno,
                'savings_acctno' => $savings_acctno,
                'business_acctno' => $business_acctno,
                'business_name' => $business_name,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'acct_email' => $acct_email,
                'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                'internetid' => $internetid,
                'acct_status' => $acct_status,
                'acct_phone' => $acct_phone,
                'acct_pin' => $acct_pin
            ]);


            
            $number = $acct_phone;
            $full_name = $firstname . " " . $lastname;
            $APP_NAME = WEB_TITLE;



            if ($page['padiwise_sms'] == '1') {
                $messageText = "Dear " . $full_name . ", Thank you for registering at " . $APP_NAME . ". Kindly wait while your account is activated, Thanks ";
                $recipient = $acct_phone;

                $responseBody = send_bulk_sms(array(
                    'sender_name' => get_setting('display_name'),
                    'recipient' => $recipient,
                    'reference' => date('Y') . uniqid() . rand(1, 9),
                    'message' => $messageText
                ));
            }


            $device = $_SERVER['HTTP_USER_AGENT'];
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    $nowDate = date('Y-m-d H:i:s');
                    
                    $stmt = $conn->prepare("INSERT INTO audit_logs (internetid,device,ipAddress,datenow) VALUES(:internetid,:device,:ipAddress,:datenow)");
                    $stmt->execute([
                        'internetid' => $internetid,
                        'device' => $device,
                        'ipAddress' => $ipAddress,
                        'datenow' => $nowDate
                    ]);


                    $details = "New Registration";
                    $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
                    $stmt2->execute([
                        'internetid' => $internetid,
                        'details' => $details
                    ]);

            if (true) {

            $log = "SELECT internetid FROM accounts WHERE internetid='$internetid'";
            $stmt = $conn->prepare($log);
            $stmt->execute();
        
            $user6 = $stmt->fetch(PDO::FETCH_ASSOC);




                $full_name = $firstname . " " . $lastname;
                $APP_NAME = WEB_TITLE;
                $APP_URL = WEB_URL;
                $SITE_ADDRESS = $page['website_address'];
                $message = $sendMail->RegisterMsg($full_name, $internetid, $acct_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                // User Email
                $subject = "Welcome to " . "-" . $APP_NAME;
                // $email_message->send_mail($acct_email, $message, $subject);


                
                
                $_SESSION['login'] = $user6['internetid'];
                $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./pin.php';
                        }
                        document.write ('');
                        
                        setTimeout('Redirect()', 6000);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                 
                <center>	<strong style='color:black;'>Account Registered... Please wait while we redirect you to dashboard!
                       </strong></center>
                
                  </div>
                ";
            } else {
                toast_alert("error", "Invalid details");
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $UniqueName ?> | Business Banking in North Carolina </title>
    <link rel="icon" type="image/x-icon" href="ui/assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="ui/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="ui/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="ui/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="ui/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="ui/assets/css/forms/switches.css">
</head>

<body class="form">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
<img src="assets/images/logo/logo.png" alt="Dogwood State Bank" itemprop="url">
                      <br><br>
                        <h1 class="">Register</h1>
                        <p class="signup-link register">Already have an account? <a href="./login.php" style="color: #617a87;">Log in</a></p>
                        <form class="text-left" method="POST" enctype="multipart/form-data" action="">
                            <div class="form">

                                <?php if (isset($msg1)) echo $msg1; ?>

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">First Name</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="username" name="firstname" type="text" class="form-control" placeholder="First Name">
                                </div>

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">Last Name</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="username" name="lastname" type="text" class="form-control" placeholder="Last Name">
                                </div>

                                <div id="email-field" class="field-wrapper input">
                                    <label for="email">Email</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                    <input id="email" name="acct_email" type="text" value="" class="form-control" placeholder="Email">
                                </div>

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">Phone Number (country code)</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input required minlength="8" autocomplete="off" placeholder="+1 213 218 5486" name="acct_phone" type="text" class="form-control" placeholder="Last Name">
                                </div>

                                <div id="username-field" class="field-wrapper input">
                                    <label for="business_name">Business Name (Optional)</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                    <input id="business_name" name="business_name" type="text" class="form-control" placeholder="Company/Business Name">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">Password</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="acct_password" type="password" class="form-control" placeholder="Password">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">Confirm Password</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="confirm_password" type="password" class="form-control" placeholder="Password">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">6 Digit Pincode</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input name="acct_pin" type="text" inputmode="numeric" required pattern="[0-9]+" minlength="6" maxlength="6" autocomplete="off" class="form-control" placeholder="******">
                                </div>

                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input type="checkbox" required class="new-control-input">
                                            <span class="new-control-indicator"></span><span>I agree to the <a href="javascript:void(0);"  style="color: #617a87;"> terms and conditions </a></span>
                                        </label>
                                    </div>

                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" class="btn btn-primary" name="regSubmit">Get Started!</button>
                                    </div>
                                </div>

                                <br>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="ui/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="ui/bootstrap/js/popper.min.js"></script>
    <script src="ui/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="ui/assets/js/authentication/form-2.js"></script>

</body>

</html>