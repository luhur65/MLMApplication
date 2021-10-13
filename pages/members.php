<?php

$query = "SELECT * FROM `member`";
$members = query($query);

if (isset($_POST['search'])) {
  $members = search($_POST['keyword']);

}

?>

<div class="container mt-3">
  <h1>Daftar Member</h1>

  <div class="row mt-3">
    <div class="col-lg-8">

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="ketik id, alamat, no telp , nama" name="keyword">
          <button class="btn btn-primary" type="submit" id="button-addon2" name="search">Search</button>
        </div>
      </form>

      <ul class="list-group">
        <?php foreach ($members as $m) : ?>
          <li class="list-group-item d-flex justify-content-between align-items-center mb-2 border-top">
            <?= $m['nama']; ?>
            <div>
              <a href="?page=daftar&upline=<?= $m['id']; ?>" class="btn btn-primary btn-sm daftar">daftar</a>
              <a href="" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal<?= $m['id'] ?>">info</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</div>

<?php foreach ($members as $m) : ?>
  <!-- Modal -->
  <div class="modal fade" id="Modal<?= $m['id'] ?>" tabindex="-1" aria-labelledby="<?= $m['id'] ?>Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Info Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php

          $queryUpline = mysqli_query($conn, "SELECT `nama` FROM member WHERE id='" . $m['idUpline'] . "'");
          $upline = mysqli_fetch_assoc($queryUpline);

          $queryd = "SELECT * FROM `member` JOIN `group` ON member.id=group.idDownline WHERE group.idUpline='" . $m['id'] . "'";
          $downln = query($queryd);

          ?>

          <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9"><?= $m['nama']; ?></dd>

            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">
              <p><?= $m['alamat']; ?></p>
            </dd>

            <dt class="col-sm-3">Upline</dt>
            <dd class="col-sm-9">
              <a href="" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#Modal<?= $m['id'] ?>"><?= ($upline != null) ? $upline['nama'] : "Tidak punya Upline"; ?></a>
            </dd>

            <dt class="col-sm-3">Downline</dt>
            <dd class="col-sm-9">
              <ul>
                <?php foreach ($downln as $dl) : ?>
                  <li><?= $dl['nama']; ?></li>
                <?php endforeach; ?>
              </ul>
            </dd>
          </dl>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>