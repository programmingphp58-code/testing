<?php
$UniqueName  = "Edit User";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


$id = $_GET['id'];
$sql = "SELECT * FROM accounts WHERE id =:id";
$data = $conn->prepare($sql);
$data->execute(['id' => $id]);

$row = $data->fetch(PDO::FETCH_ASSOC);

$currency = $row['acct_currency'];



if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../ui/assets/img/"; 
        $n = $row['internetid'] . $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE accounts SET acct_image=:image WHERE id =:id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image' => $n,
            'id' => $id

        ]);

        if (true) {
            toast_alert("success", "Your Image Uploaded Successfully", "Thanks!");
        } else {
            echo "invalid";
        }
    }
}

if (isset($_POST['profile_save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $acct_email = $_POST['acct_email'];
    $acct_gender = $_POST['acct_gender'];
    $billing_code = $_POST['billing_code'];
    $transfer = $_POST['transfer'];
    $acct_currency = $_POST['acct_currency'];
    $acct_phone = $_POST['acct_phone'];
    $acct_address = $_POST['acct_address'];
    $acct_dob = $_POST['acct_dob'];
    $savings_balance = $_POST['savings_balance'];
    $current_balance = $_POST['current_balance'];
    $loan_balance = $_POST['loan_balance'];
    $business_balance = isset($_POST['business_balance']) ? $_POST['business_balance'] : '0';
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : '';
    $state = $_POST['state'];



    $sql = "UPDATE accounts SET firstname=:firstname,lastname=:lastname,current_balance=:current_balance,business_balance=:business_balance,business_name=:business_name,acct_email=:acct_email,acct_gender=:acct_gender,billing_code=:billing_code,transfer=:transfer,acct_currency=:acct_currency,acct_phone=:acct_phone,acct_address=:acct_address,acct_dob=:acct_dob,savings_balance=:savings_balance,loan_balance=:loan_balance,state=:state WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'current_balance' => $current_balance,
        'business_balance' => $business_balance,
        'business_name' => $business_name,
        'acct_email' => $acct_email,
        'acct_gender' => $acct_gender,
        'billing_code' => $billing_code,
        'transfer' => $transfer,
        'acct_currency' => $acct_currency,
        'acct_phone' => $acct_phone,
        'acct_address' => $acct_address,
        'acct_dob' => $acct_dob,
        'savings_balance' => $savings_balance,
        'loan_balance' => $loan_balance,
        'state' => $state,
        'id' => $id
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
        
        
        <center>	<strong style='color:black;'>Account updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        toast_alert('error', 'Sorry something went wrong');
    }
}





if (isset($_POST['change_pin'])) {
    $current_pin = inputValidation($_POST['current_pin']);
    $new_pin = inputValidation($_POST['new_pin']);
    $confirm_pin = inputValidation($_POST['confirm_pin']);
    $verify_pin = $row['acct_pin'];

    if ($current_pin !== $verify_pin) {
        toast_alert('error', 'Invalid Old Pin');
    } else if ($new_pin !== $confirm_pin) {
        toast_alert('error', 'Confirm Pin not Matched');
    } else if ($new_pin === $verify_pin) {
        toast_alert('error', 'New Pin Matched with Old Pin');
    } else {
        $sql2 = "UPDATE accounts SET acct_pin=:acct_pin WHERE id =:id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_pin' => $new_pin,
            'id' => $id
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
        
        
        <center>	<strong style='color:black;'>Pin Changed successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

if (isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
    $verification = password_verify($old_password, $row['acct_password']);

    if ($verification === false) {
        toast_alert("error", "Incorrect Old Password");
    } else if ($new_password !== $confirm_password) {
        toast_alert("error", "Confirm Password not matched");
    } else if ($new_password === $old_password) {
        toast_alert('error', 'New Password Matched with Old Password');
    } else {
        $sql2 = "UPDATE accounts SET acct_password=:acct_password WHERE id =:id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'acct_password' => $new_password2,
            'id' => $id
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
            
            
            <center>	<strong style='color:black;'>Your Password Change Successfully, Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

if (isset($_POST['status_submit'])) {
    $acct_status = $_POST['acct_status'];
    $kyc_status = "1";
    $kyc_pending = "1";

    $sql = "UPDATE accounts SET acct_status=:acct_status,kyc_status=:kyc_status,kyc_pending=:kyc_pending WHERE id =:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_status' => $acct_status,
        'kyc_status' => $kyc_status,
        'kyc_pending' => $kyc_pending,
        'id' => $id
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
        
        
        <center>	<strong style='color:black;'>Account Status Change to ($acct_status), Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        toast_alert('error', 'Sorry Something Went Wrong');
    }
}


function BillingCode($row)
{
    if ($row['billing_code'] == '1') {
        return 'ACTIVE';
    }

    if ($row['billing_code'] == '0') {
        return 'Disactivated';
    }
}

$BillingCode = BillingCode($row);

function TransferCode($row)
{
    if ($row['transfer'] == '1') {
        return 'ACTIVE';
    }

    if ($row['transfer'] == '0') {
        return 'Disactivated';
    }
}

$TransferCode = TransferCode($row);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit User Profile
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
                                <input type="text" class="form-control" placeholder="<?= $row['firstname'] ?>" name="firstname" value="<?= $row['firstname'] ?>">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" class="form-control" value="<?= $row['lastname'] ?>" placeholder="<?= $row['lastname'] ?>" name="lastname">
                            </div>
                            <!-- /.form-group -->
                           

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" value="<?= $row['acct_email'] ?>" placeholder="<?= $row['acct_email'] ?>" name="acct_email">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control select2" name="acct_gender">
                                    <option value="<?= $row['acct_gender'] ?>">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Billing Code Option <span style="color: red;"><?= $BillingCode ?></label>
                                <select class="form-control select2" name="billing_code" style="width: 100%;">
                                    <option value="<?= $row['billing_code'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Transfer Code Option <span style="color: red;"><?= $TransferCode ?></label>
                                <select class="form-control select2" name="transfer" style="width: 100%;">
                                    <option value="<?= $row['transfer'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>

                            


                            <div class="form-group">
                                <label>State</label>
                                <input type="text" value="<?= $row['state'] ?>" class="form-control" name="state" placeholder="<?= $row['state'] ?>">
                            </div>


                            <table class="table table-bordered mb-4">
                                <tbody>

                                      <tr>
                                        <th>Front ID Card</th>
                                        <th><a href="<?= $web_url ?>/ui/assets/img/<?= $row['idfront'] ?>" target="_blank"><img src="<?= $web_url ?>/ui/assets/img/<?= $row['idfront'] ?>" width="20%" alt=""></a></th>
                                    </tr>
                                    <tr>
                                        <th>Back ID Card</th>
                                        <th>

                                            <a href="<?= $web_url ?>/ui/assets/img/<?= $row['idBack'] ?>" target="_blank"><img src="<?= $web_url ?>/ui/assets/img/<?= $row['idBack'] ?>" width="20%" alt=""></a>
                                        </th>

                                    </tr>
                                    
                                </tbody>
                            </table>



                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Phone</label>
                                <input type="text" required minlength="8" autocomplete="off" placeholder="<?= $row['acct_phone'] ?>" value="<?= $row['acct_phone'] ?>" class="form-control wizard-required" name="acct_phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Account Address</label>
                                <input type="text" value="<?= $row['acct_address'] ?>" class="form-control" name="acct_address" placeholder="<?= $row['acct_address'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Date of Birth</label>
                                <input type="date" class="form-control" value="<?= $row['acct_dob'] ?>" name="acct_dob" placeholder="<?= $row['acct_dob'] ?>">
                            </div>

                           

                            <div class="form-group">
                                <label for="exampleInputEmail1">Savings Balance</label>
                                <input type="number" class="form-control" value="<?= $row['savings_balance'] ?>" name="savings_balance" placeholder="<?= $row['savings_balance'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Current Balance</label>
                                <input type="number" class="form-control" value="<?= $row['current_balance'] ?>" name="current_balance" placeholder="<?= $row['current_balance'] ?>">
                            </div>
                           
                            <div class="form-group">
                                <label>Account Currency: <?= $row['acct_currency'] ?></label>
                                <select class="form-control select2" name="acct_currency" style="width: 100%;">
                                    <option value="<?= $row['acct_currency'] ?>">Select Currency Type</option>
                                    <option value="$">USD</option>
                                    <option value="€">EURO</option>
                                    <option value="CHF">CHF</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loan</label>
                                <input type="number" value="<?= $row['loan_balance'] ?>" class="form-control" name="loan_balance" placeholder="<?= $row['loan_balance'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Business Account Number</label>
                                <input type="text" value="<?= $row['business_acctno'] ?? 'N/A' ?>" class="form-control" readonly style="background-color: #f4f4f4;">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Business Balance</label>
                                <input type="number" value="<?= $row['business_balance'] ?? '0' ?>" class="form-control" name="business_balance" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Business Name</label>
                                <input type="text" value="<?= $row['business_name'] ?? '' ?>" class="form-control" name="business_name" placeholder="Company/Business Name">
                                        <th><a href="<?= $web_url ?>/ui/assets/img/<?= $row['acct_image'] ?>" target="_blank"><img src="<?= $web_url ?>/ui/assets/img/<?= $row['acct_image'] ?>" width="20%" alt=""></a></th>
                                    </tr>
                                    <tr>
                                        <th>Address Proof</th>
                                        <th>

                                            <a href="<?= $web_url ?>/ui/assets/img/<?= $row['proofaddress'] ?>" target="_blank"><img src="<?= $web_url ?>/ui/assets/img/<?= $row['proofaddress'] ?>" width="20%" alt=""></a>
                                        </th>

                                    </tr>
                                    
                                </tbody>
                            </table>
                            


                            
                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="profile_save" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </form>
        <!-- /.box -->

        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Current Password</label>
                                <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">New Password</label>
                                <input type="password" class="form-control" name="new_password" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Old Password">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="change_password" class="btn btn-primary">Change
                                Password</button>
                        </div>
                    </form>
                </div>
                <div>
                    Profile Image
                </div>
                <form method="POST" id="general-info" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" id="input-file-max-fs" class="form-control" name="image" data-max-file-size="2M" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="upload_picture" class="btn btn-primary">Change Image</button>
                    </div>
                </form>
                <br><br>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Current Pin : <?= $row['acct_pin'] ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" autocomplete="off" autofocus="off">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Old Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="6" autocomplete="off" class="form-control" name="current_pin" placeholder="Current Pin">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">New Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="6" autocomplete="off" class="form-control" name="new_pin" placeholder="New Pin">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirm New Pin</label>
                                <input type="text" inputmode="numeric" required pattern="[0-9]+" maxlength="6" autocomplete="off" class="form-control" name="confirm_pin" placeholder="Confirm Pin">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="change_pin" class="btn btn-primary">Change Pin</button>
                        </div>
                    </form>
                </div>

                <div>
                    CURRENT STATUS: <b><?= ucwords($row['acct_status']) ?></b>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <select class="form-control select2" name="acct_status" style="width: 100%;">
                            <option>Select Account Status</option>
                            <option value="active">Activate/Approve</option>
                            <option value="hold">Hold/Reject</option>
                        </select>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="status_submit" class="btn btn-primary">Update Account/Kyc</button>
                    </div>
                </form>
                <br><br>


                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>