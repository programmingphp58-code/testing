<?php



$UniqueName  = "Login";

require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/headerlogin.php");

if (isset($_POST['admin_login'])) {
  $admin_email = inputValidation($_POST['admin_email']);
  $admin_password = inputValidation($_POST['admin_password']);

  $sql = "SELECT * FROM admin WHERE admin_email=:admin_email";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    'admin_email' => $admin_email
  ]);

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($stmt->rowCount() === 0) {
    toast_alert('error', 'incorrect password / email');
  } else {
    $validPassword = password_verify($admin_password, $row['admin_password']);

    if ($validPassword === false) {
      toast_alert('error', 'incorrect password / email');
    } else {
      $_SESSION['admin'] = $admin_email;
      header("Location:./dashboard.php");
      exit;
    }
  }
}


?>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="admin_email" placeholder="Email">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="admin_password" class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" name="admin_login" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>



    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->


  <?php
  require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footerlogin.php");

  ?>