<?php
namespace models;

use database\Database;

class Hospital {

  public static function getHospitalById($id) {
    $result = Database::queryParams('SELECT * FROM hospital WHERE id = $1', Array($id));
    return pg_fetch_object($result);
  }

  public static function getSurgeries($id) {
      /* SELECT s.name, s.specialty, s.crm FROM hospital AS h
        INNER JOIN hospital_surgeryform AS hsf
        	ON h.id = hsf.idHospital
        INNER JOIN surgeryform AS sf
        	ON hsf.idsurgeryform = sf.id
        INNER JOIN surgeon_surgeryform AS ssf
        	ON sf.id = ssf.idsurgeryform
        INNER JOIN surgeon AS s
        	ON ssf.idsurgeon = s.email; */
  }
}

 ?>
