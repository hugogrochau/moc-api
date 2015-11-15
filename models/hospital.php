<?php
namespace models;

// require '../database/database.php';

use database\Database;

class Hospital {

  public static function getHospitalById($id) {
    $result = Database::queryParams('SELECT * FROM hospital WHERE id = $1', Array($id));
    return pg_fetch_object($result);
  }

  public static function getSurgeries($id) {

  }
}

 ?>
