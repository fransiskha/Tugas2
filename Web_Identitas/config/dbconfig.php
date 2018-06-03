<!--File ini digunakan untuk membuka koneksi ke database.
karena konsep pembuatan web adalah OOP, maka file ini dapat digunakan
atau include ke dalam file lain dengan memanggil class Dbconfig
-->
 <?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','identitas');

class Dbconfig {
    var $conn;
    function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            echo $this->conn->connect_error;
        }
    }
}

?>