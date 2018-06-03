<!--File php ini digunakan untuk membaca seluruh data yang berada pada database identitas-->
<!--dan untuk eksekusi query CRUD tabel identitas-->
<?php
//pemanggilan file Dbconfig untuk koneksi ke database
include_once 'dbconfig.php';
class Dao {
    
    //konstruktor class dao
    var $link;
    public function __construct() {
        $this->link = new Dbconfig();
    }
    
    //prodesedur untuk menampilkan data ke tabel yang berada pada file index
    public function read() {
        $query = "SELECT * FROM identitas ORDER BY ID_KTP";
        return mysqli_query($this->link->conn, $query);
    }
    
    //prosedur yang digunakan untuk eksekusi perintah-perintah CRUD ke tabel identitas
    
    public function execute($query) {
        $result = mysqli_query($this->link->conn, $query);
        if ($result) {
            return $result;
        }else {
            return mysqli_error($this->link->conn);
        }
         
    }
}
