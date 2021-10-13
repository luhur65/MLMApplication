<?php

if (!isset($_GET['upline']) || empty($_GET['upline'])) {
  header("Location: ?page=members");
}

$uplineName = "";
$downline = 0;
$uplineID = $_GET['upline'];
$query = "SELECT `nama`, `id` FROM `member` WHERE id='" . $uplineID . "'";

$upline = mysqli_query($conn, $query);
if (mysqli_num_rows($upline) > 0) {

  $up = mysqli_fetch_assoc($upline);

  $query = "SELECT * FROM `group` WHERE idUpline='" . $up['id'] . "'";
  $downline = count(query($query));

  $uplineName = $up['nama'];
}

$success = false;
if (isset($_POST['submit'])) {
  if (daftarMember($_POST, $uplineID) > 0) {
    $success = true;
  }
}

?>

<div class="container mt-3">
  <h1>Form Registrasi</h1>

  <div class="row mt-4">
    <div class="col-lg-8">
      <?php if ($success) : ?>
        <div class="alert alert-success" role="alert">
          Berhasil Daftar!!.
        </div>
      <?php endif; ?>
      <form action="" method="post">
        <div class="mb-3 row">
          <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="inputNoHp" class="col-sm-3 col-form-label">No.Hp</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="inputNoHp" name="nohp">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
          <div class="col-sm-9">
            <textarea class="form-control" id="alamat" style="height: 100px;" name="alamat"></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="upline" class="col-sm-3 col-form-label">Your Upline Name</label>
          <div class="col-sm-9">
            <?php if (isset($_GET['upline'])) : ?>
              <input type="text" readonly class="form-control-plaintext" id="upline" value="<?= $uplineName; ?>">
              </select>
            <?php endif; ?>
          </div>
        </div>
        <div class="mb-3 row">
          <div class="col-sm-6 mt-4">
            <?php if ($downline == 2) : ?>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Daftar jadi Downline
              </button>
            <?php else : ?>
              <button class="btn btn-primary" type="submit" name="submit">Daftar jadi Downline</button>
            <?php endif; ?>
            <a href="?page=members" class="btn btn-outline-danger">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warning!!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Downline penuh!</strong> Silakan pilih upline yang lain!! 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <ul class="list-group">
          <?php
          $members = query("SELECT * FROM `member`");

          foreach ($members as $m) : ?>
            <?php

            $group = query("SELECT * FROM `group` WHERE idUpline='" . $m['id'] . "'");

            if (count($group) <= 1) : ?>
              <li class="list-group-item d-flex justify-content-between align-items-center mb-2 border-top">
                <?= $m['nama']; ?>
                <a href="?page=daftar&upline=<?= $m['id']; ?>" class="btn btn-primary btn-sm">Pilih Ini!</a>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>