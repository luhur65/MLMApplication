<?php 

require_once('./config.php');

require_once('./layouts/header.php');

if (isset($_GET['page'])) {
  $page = $_GET['page'];

  switch ($page) {
    case 'daftar':
      require_once('./pages/daftar.php');
      break;
    case 'members':
      require_once('./pages/members.php');
      break;
    
    default:
      require_once('./pages/home.php');
      break;
  }

} else {
  require_once('./pages/home.php');

}

require_once('./layouts/footer.php');


?>