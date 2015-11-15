<?php
namespace models;

// require '../database/database.php';

use database\Database;

class Hospital {

  public function getHospitalById($id) {
    $result = Database::queryParams('SELECT * FROM hospital WHERE id = $1', Array($id));
    return pg_fetch_object($result);
  }

  public function getSurgeries($id) {

  }
}

 ?>
