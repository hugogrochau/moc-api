<?php
namespace MocApi\Database;

use MocApi\Database\DbInfo;

class Database {

  /* Returns the database connection using the information defined in dbinfo.php */
  public static function getConnection() {
    $dbcon = pg_connect(DBInfo::getConnString())
    or die('Error connecting to database');
    return $dbcon;
  }

  public static function query($str) {
    return pg_query(self::getConnection(), $str);
  }

  public static function queryParams($str, $arr) {
    return pg_query_params(self::getConnection(), $str, $arr);
  }

}
?>
