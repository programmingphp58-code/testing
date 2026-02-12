<?php




$UniqueName  = "Create Profile";
include($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['register'])) {
    $internetid = "1202" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $current_acctno = "36378" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $savings_acctno = "67392" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $business_acctno = "89254" . (substr(number_format(time() * rand(), 0, '', ''), 0, 6));
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_status = "hold";
    $acct_gender = $_POST['acct_gender'];
    $acct_address = $_POST['acct_address'];
    $loan_balance = $_POST['loan_balance'];
    $current_balance = $_POST['current_balance'];
    $savings_balance = $_POST['savings_balance'];
    $business_balance = $_POST['business_balance'];
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : '';
    $state = $_POST['state'];
    $acct_email = $_POST['acct_email'];
    $acct_phone = $_POST['acct_phone'];
    $acct_password = inputValidation($_POST['acct_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);
    $acct_dob = $_POST['acct_dob'];
    $acct_pin = inputValidation($_POST['acct_pin']);

    if ($acct_password !== $confirm_password) {
        toast_alert('error', 'Password not matched');
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
            if (isset($_FILES['image'])) {
                $file = $_FILES['image'];
                $name = $file['name'];

                $path = pathinfo($name, PATHINFO_EXTENSION);

                $allowed = array('jpg', 'png', 'jpeg');


                $folder = "../ui/assets/img/";
                $n = $internetid . $name;

                $destination = $folder . $n;
            }
            //INSERT INTO DATABASE
            $registered = "INSERT INTO accounts (savings_balance,current_balance,business_balance,current_acctno,savings_acctno,business_acctno,business_name,loan_balance,firstname,lastname,acct_email,acct_password,internetid,acct_status,acct_phone,acct_gender,state,acct_address,acct_dob,acct_pin,acct_image) VALUES(:savings_balance,:current_balance,:business_balance,:current_acctno,:savings_acctno,:business_acctno,:business_name,:loan_balance,:firstname,:lastname,:acct_email,:acct_password,:internetid,:acct_status,:acct_phone,:acct_gender,:state,:acct_address,:acct_dob,:acct_pin,:acct_image)";
            $reg = $conn->prepare($registered);
            $reg->execute([
                'savings_balance' => $savings_balance,
                'current_balance' => $current_balance,
                'business_balance' => $business_balance,
                'current_acctno' => $current_acctno,
                'savings_acctno' => $savings_acctno,
                'business_acctno' => $business_acctno,
                'business_name' => $business_name,
                'loan_balance' => $loan_balance,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'acct_email' => $acct_email,
                'acct_password' => password_hash((string)$acct_password, PASSWORD_BCRYPT),
                'internetid' => $internetid,
                'acct_status' => $acct_status,
                'acct_phone' => $acct_phone,
                'acct_gender' => $acct_gender,
                'state' => $state,
                'acct_address' => $acct_address,
                'acct_dob' => $acct_dob,
                'acct_pin' => $acct_pin,
                'acct_image' => $n
            ]);

            if (true) {


                $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./users.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 3000);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                 
                <center>	<strong style='color:black;'>Registered, Welcome Email Sent...
                       </strong></center>
                <center>	<strong style='color:black;'>Please Wait while we redirect to login...
                       </strong></center>
                  </div>
                ";
            } else {
                toast_alert('error', 'Sorry something went wrong');
            }
        }
    }
}




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create New User
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <form method="POST" enctype="multipart/form-data" action="">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" name="firstname" required class="form-control" placeholder="First Name">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" name="lastname" required class="form-control" placeholder="Last Name">
                            </div>
                            <!-- /.form-group -->
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" required placeholder="Enter Email" name="acct_email">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Savings Balance</label>
                                <input type="number" required inputmode="numeric" required pattern="[0-9]+" maxlength="15" autocomplete="off" name="savings_balance" class="form-control" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control select2" required name="acct_gender">
                                    <option>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Zipcode</label>
                                <input type="text" required name="zipcode" inputmode="numeric" required pattern="[0-9]+" minlength="3" maxlength="5" autocomplete="off" class="form-control" placeholder="23456">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" required class="form-control" name="acct_password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" required class="form-control" name="confirm_password" placeholder="Confirm Password">
                            </div>
                           

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone Number (country code)</label>
                                <input type="text" required minlength="8" autocomplete="off" placeholder="+1 213 218 5486" class="form-control wizard-required" name="acct_phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Home Address</label>
                                <input name="acct_address" required type="text" class="form-control" placeholder="Address">
                                <input value="50000000" name="limit_remain" type="text" hidden>

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="date" required class="form-control" name="acct_dob" placeholder="Date of birth">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Current Balance</label>
                                <input type="number" required inputmode="numeric" required pattern="[0-9]+" maxlength="15" autocomplete="off" name="current_balance" class="form-control" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loan Balance</label>
                                <input inputmode="numeric" required pattern="[0-9]+" maxlength="15" autocomplete="off" type="number" required name="loan_balance" class="form-control" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Business Balance</label>
                                <input type="number" required inputmode="numeric" required pattern="[0-9]+" maxlength="15" autocomplete="off" name="business_balance" class="form-control" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Business Name (Optional)</label>
                                <input type="text" name="business_name" class="form-control" placeholder="Company/Business Name">
                            </div>

                            <div class="form-group">
                                <label>State</label>
                                <input type="text" required class="form-control" name="state" placeholder="Enter State">
                            </div>

                            <div class="form-group">
                                <label>Upload Picture</label>
                                <input type="file" id="input-file-max-fs" required class="form-control" name="image" data-max-file-size="2M" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            </div>


                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">6 Digit Transaction Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" minlength="3" maxlength="6" autocomplete="off" required class="form-control" name="acct_pin" placeholder="Enter Pin">
                            </div>

                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="register" class="btn btn-primary">Create New Profile</button>
                </div>
            </div>
        </form>
        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>