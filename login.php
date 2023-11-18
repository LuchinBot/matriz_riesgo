<?php
$login = 1;
include "layout/header.php";
if (isset($_SESSION['user'])) {
  header('Location: matriz');
}
$display = 0;
if (isset($_POST['login'])) {
  $user = $_POST['user'];
  $token = $_POST['key'];

  $stm = $base->prepare('SELECT * from user where username=? and keyword = ?');
  $res = $stm->execute(array($user,$token));
  $res = $stm->fetch(PDO::FETCH_ASSOC);

  if ($res) {
    $_SESSION['user'] = $res['iduser'];
    $_SESSION['fullname'] = $res['firstname'].' '.$res['lastname'];
    echo '<script>window.location.href = "' . $url . 'matriz";</script>';
  } else {
    $display = 1;
  }
}

?>

<div class="wrapper">
  <div class="py-3 px-5 bg-white main-login">
    <div class="error-login" style="opacity:<?= $display ?>">
      <div class="error-btn">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
    </div>
    <div class="mb-2">
      <img src="<?= $url ?>dist/img/loginv2.jpg" style="width: 100%;">
    </div>
    <form class="m-t" role="form" method="post">
      <div class="form-inputs" style="display:none">
        <div class="form-group-login">
          <i class="fa-regular fa-user"></i>
          <input type="text" class="form-control-login" name="user" autocomplete="off" />
        </div>
        <div class="form-group-login mb-5">
          <i class="fa-regular fa-eye"></i>
          <input type="password" class="form-control-login" name="key" autocomplete="off" />
        </div>
      </div>
      <div class="scroll-login">
        <div class="scroll">
          <button type="button" name="login" class="btn-login">
            <i class="fa-solid fa-caret-down"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include "layout/footer.php"; ?>