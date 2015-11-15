<?php
namespace database;

require 'dbinfo.php';

class Database {

  /* Returns the database connection using the information defined in dbinfo.php */
  public function getConnection() {
    $dbcon = pg_connect(DBInfo::getConnString())
    or die('Error connecting to database');
    return $dbcon;
  }

  public function query($str) {
    return pg_query(self::getConnection(), $str);
  }

  public function queryParams($str, $arr) {
    return pg_query_params(self::getConnection(), $str, $arr);
  }

}
?>
