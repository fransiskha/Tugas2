<!--
File ini merupakan proses query untuk melakukan simpan,update delete (CRUD)
mengambil nilai nilai dalam form yang telah dibuat di file Index.php .
Menggunakan percabangan IF agar dapat mengeksekusi tiap tiap query yang nanti akan di proses kembali
di file dao.php

-->

<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
include_once 'config/dao.php';
$dao = new Dao();
/* ================================================== */
//-- Diambil dari form atau modal tambah data--
$proc = $_POST['proc'];
$usrid = $_POST['usrid'];
//-------------------
//kondisi jika akan menghapus data yang di konfirmasi dari modal-delete
if ($proc == "usrdel") {
    $query = "DELETE FROM identitas WHERE ID_KTP=$usrid";
}
//kondisi untuk insert ke tabel identitas, nilai-nilainya diambil dari modal-tambahdata
elseif ($proc == "usrin" && $usrid == 0) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $id_ktp = $_POST['id_ktp'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $tgl_lhr = $_POST['tgl_lhr'];  
    $alamat = $_POST['alamat'];  
    //end for
    $query = "INSERT INTO `identitas` (`ID_KTP`, `USERNAME`, `PASSWORD`, `EMAIL`, `FULLNAME`, `TTL`, "
            . "`ALAMAT`, `NO_TELPON`, `BANNED`, `LOGINTIME`) VALUES ('$id_ktp', '$username', '$password', '$email',"
            . " '$fullname', '$tgl_lhr', '$alamat', '$telp', NULL, NULL)";  
    
}
//kondisi untuk menampilkan data ke modal-edit ketika tombol edit diklik
//dengan nilai balikan atau result dari json
//eksekusi query berdasarkan primary key yaitu ID_KTP
elseif ($proc == "usredt" && $usrid > 0) {
    $query = "SELECT ID_KTP, USERNAME, FULLNAME, EMAIL, TTL, NO_TELPON,ALAMAT,PASSWORD FROM `identitas` where ID_KTP='$usrid'";
    $result = $dao->execute($query);
    $list = mysqli_fetch_array($result);
    echo json_encode($list);
    exit();
    
}
//kondisi jika tombol simpan di modal update di klik
//kemudian eksekusi query update ke file dao.php
elseif ($proc == "usrin" && $usrid > 0) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $id_ktp = $_POST['id_ktp'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $tgl_lhr = $_POST['tgl_lhr'];  
    $alamat = $_POST['alamat']; 
    $query = "UPDATE `identitas` SET `USERNAME` = '$username', `PASSWORD` = '$password', 
        `EMAIL` = '$email', `FULLNAME` = '$fullname', `TTL` = '$tgl_lhr',
        `ALAMAT` = '$alamat', `NO_TELPON` = '$telp' WHERE `identitas`.`ID_KTP` = '$id_ktp'";    
}

$in = $dao->execute($query);

if (!$in) {
    $msg[0] = "0";
    $msg[1] = $in;
} else {
    $result = $dao->read();
    $i = 1;
    $userlist = "";
    $msg[0] = "1";
    foreach ($result as $value) {
        $userlist .= "<tr>
                <td>" . $i . "</td>
                <td>" . $value['id_ktp'] . "</td>
                <td>" . $value['username'] . "</td>
                <td>" . $value['fullname'] . "</td>
                <td>" . $value['email'] . "</td>
                <td>" . $value['telp'] . "</td>
                <td>" . $value['baned'] . "</td>
                <td>" . $value['logintime'] . "</td>
                <td>" . $value['akses'] . "</td>
                <td nowrap>
                    <button type=\"button\" class=\"btn btn-primary btn-sm\">
                        <i class=\"fa fa-list\"></i> Detail
                    </button>
                    <button type=\"button\" onclick=\"showModalEdt(".$value['id'].");\" class=\"btn btn-success btn-sm\">
                        <i class=\"fa fa-edit\"></i> Edit
                    </button>
                    <button type=\"button\" onclick=\"showModalDel(".$value['id'].",'".$value['fullname']."');\" class=\"btn btn-danger btn-sm\">
                        <i class=\"fa fa-trash\"></i> Del 
                    </button>
                </td>
            </tr>";
        $i++;
    }
    $msg[1] = $userlist;
}
/* ================================================== */
echo json_encode($msg);
