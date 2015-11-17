<?php
namespace MocApi\Models;

use MocApi\Database\Database;

class User {

    public static function getUserByUsername($username) {
        $result = Database::queryParams('SELECT * FROM hospitalsecretary WHERE username = $1', Array($username));
        return pg_fetch_object($result);
    }

    public static function userExists($username) {
        $result = Database::queryParams('SELECT username FROM hospitalsecretary WHERE username = $1',
        Array($username));
        return  pg_num_rows($result) === 1;
    }

    public static function register($username, $password, $name) {
        // fail if user already exists
        if (self::userExists($username)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $result = Database::queryParams('INSERT INTO hospitalsecretary (username, password, name) VALUES ($1, $2, $3)',
        Array($username, $hashedPassword, $name));
        return pg_affected_rows($result) === 1;
    }

    public static function authenticate($username, $password) {
        $result = Database::queryParams('SELECT password FROM hospitalsecretary WHERE username = $1',
        Array($username));
        $hashedPassword = pg_fetch_result($result, 0, 'password');
        return password_verify($password, $hashedPassword);
    }
}

 ?>
