<?php
namespace MocApi\Database;

class DBInfo {

  const DB_HOST = 'bepidhml.les.inf.puc-rio.br';
  const DB_PORT = '5432';
  const DB_NAME = 'bepid_students';
  const DB_USER = 'moc';
  const DB_PASSWORD = 'moc@bepid!';

  public static function getConnString() {
    return sprintf("host=%s port=%s dbname=%s user=%s password=%s",
    self::DB_HOST,
    self::DB_PORT,
    self::DB_NAME,
    self::DB_USER,
    self::DB_PASSWORD);
  }
}
?>
