<?php

// Konekesi Ke Database 
$hostname = 'localhost';
$username = 'root';
$pass = '';
$dbname = 'mlm';

$conn = mysqli_connect($hostname, $username, $pass, $dbname);

// Function Query Database
function query($query)
{

  global $conn;
  $result = mysqli_query($conn, $query);
  $rows   = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;

}

function daftarMember($data, $uplineID) {

  global $conn;

  $nama =  $data['nama'];
  $alamat = $data['alamat'];
  $hp = $data['nohp'];

  $query = "INSERT INTO `member`(`nama`, `alamat`, `noTelp`, `idUpline`) 
            VALUES ('".$nama."', '".$alamat."', '".$hp."', '".$uplineID."')";

  mysqli_query($conn, $query);

  $idDownline = mysqli_insert_id($conn);
  
  mysqli_query($conn, "INSERT INTO `group`(`idUpline`, `idDownline`) VALUES ('".$uplineID."', '".$idDownline."')");

  return mysqli_affected_rows($conn);

}

function search($keyword) {
  $query = "SELECT * FROM `member` WHERE
                id LIKE '%$keyword%' OR
                nama LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%' OR
                noTelp LIKE '%$keyword%'";

  return query($query);
}



?>