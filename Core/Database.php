
<?php

class Database
{
    const SERVER_NAME = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = '';
    const DB_NAME = 'phpclass';


    public function connect() {
        $connect = mysqli_connect(self::SERVER_NAME, self::USERNAME, self::PASSWORD, self::DB_NAME);
        mysqli_set_charset($connect, 'utf8');
        if (mysqli_connect_error()) {
            die("Database connection failed: " . mysqli_connect_error());
          }
        return $connect;
    }
}