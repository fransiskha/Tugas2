<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="icon" href="assets/images/favicon.ico">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/floating-labels.css">        
        <link rel="stylesheet" href="assets/awesome/css/fontawesome-all.min.css">
        <!--link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"-->
        <script>
            //prosedur untuk menampilkan modal tambah data
            //prosedur ini akan dieksekusi ketika tombol tambah data di pojok kiri diklik
            function showModalKu() {
                $('#idusr').val(0);
                $('#username').val('');
                $('#fullname').val('');
                $('#email').val('');
                $('#telp').val('');                
                $('#ModalKu').modal('show');                
            }  
            //prosedur untuk menampilkan modal konfirmasi menghapus data
            //dengan parameter id_ktp dan nama
            //tombol ini terletak pada setiap baris sebuah data
            function showModalDel(id_ktp,nm) {
                $('#usriddel').val(id_ktp);
                $('#nmusr').text(nm);
                $('#ModalDel').modal('show');                
            }    
            
            //prosedur untuk menampilkan modal edit
            //data data akan otomatis tampil kedalam setiap field yang didapat dari file execute.php
            
            function showModalEdt(id_ktp) {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: "proc=usredt&usrid="+id_ktp,
                    cache: false,
                    dataType: "json",
                    success: function (data) {                        
                        console.log(data);
                        $('#idusr').val(data.ID_KTP);
                        $('#id_ktp').val(data.ID_KTP);
                        $('#username').val(data.USERNAME);
                        $('#fullname').val(data.FULLNAME);
                        $('#password').val(data.PASSWORD);
                        $('#email').val(data.EMAIL);
                        $('#telp').val(data.NO_TELPON);
                        $('#alamat').val(data.ALAMAT);
                        $('#tgl_lhr').val(data.TTL);
                        $('#ModalKu').modal('show');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }

            
        </script>   
        <style>
            /*
            .modal-dialog {
                      width: 360px;
                      height:600px !important;
            }
            
            .modal-content {
                /* 80% of window height 
                height: 60%;
                background-color:#BBD6EC;
            }       
            */
            .modal-header {
                background-color: #337AB7;
                padding:16px 16px;
                color:#FFF;
                border-bottom:2px dashed #337AB7;
            } 
            .modal-header-danger {
	color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #d9534f;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
        </style>
    </head>
    <body>
       
        <div class="container mb-auto">
            <!--Ini adalah baris untuk peletakan tombol tambah data yang berada di pojok kiri atas-->
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-success" onclick="showModalKu();">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            
            <!--ini tabel identitas-->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID KTP</th>
                            <th>User Name</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="userlist">
                         <?php
                            ini_set('display_errors', 'On');
                            error_reporting(E_ALL);
                            //pemanggilan class dao pada file dao.php
                            //memanggil prosedur read untuk menampilkan data ke baris tabel
                            include_once 'config/dao.php';
                            $dao = new Dao();
                            $result = $dao->read();
                            
                        ?>
                        <?php
                        $i = 1;
                        while ($value = mysqli_fetch_array($result)){

                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['ID_KTP']; ?></td>
                                <td><?php echo $value['USERNAME']; ?></td>
                                <td><?php echo $value['FULLNAME']; ?></td>
                                <td><?php echo $value['EMAIL']; ?></td>
                                <td><?php echo $value['NO_TELPON']; ?></td>
                                <td><?php echo $value['ALAMAT']; ?></td>                                
                                <td nowrap>
                                    <!--tombol modal edit-->
                                    <button type="button" onclick="showModalEdt( <?php echo $value['ID_KTP']; ?> );" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <!--tombol modal konfirmasi hapus data-->
                                    <button type="button" onclick="showModalDel(<?php echo $value['ID_KTP']; ?>,'<?php echo $value['FULLNAME']; ?>');" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Del 
                                    </button>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--ini akhir dari tabel identitas-->
            
            <!--MODAL TAMBAH DATA ATAU EDIT DATA -->            
            <div class="modal fade" id="ModalKu" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel01">
                                Tambah Data Identitas
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-tambahdata">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <!--label for="recipient-name" class="form-control-label">Recipient:</label-->
                                            <input type="hidden" name="usrid" id="idusr">
                                            <input type="hidden" name="proc" value="usrin">
                                            <input type="text" name="id_ktp" class="form-control" id="id_ktp" placeholder="ID KTP">
                                            
                                        </div>                                    
                                    </div>
                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        </div>                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Fullname">
                                </div>
                                
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                        </div>                                    
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <input type="number" name="telp" class="form-control" id="telp" placeholder="Telpon ">
                                        </div>                                    
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="rdbaned" class="form-control-label">Tanggal Lahir:</label>
                                            <input type="date" name="tgl_lhr" id="tgl_lhr" class="form-control" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="cbaccess" class="form-control-label">Alamat:</label>
                                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                                        </div>                                    
                                    </div>
                                </div>
                            </form>
                            <!--p>disini isi dari modalnya</p-->
                            <!--p id="dariajax"></p-->
                        </div>
                        <div class="modal-footer">
                            <button onclick="insertUser();" class="btn btn-success" type="button" data-dismiss="modal">
                                Simpan
                            </button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal">
                                Clear
                            </button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AKHIR DARI MODAL TAMBAH ATAU EDIT DATA -->
            <!-- Modal KONFIRMASI HAPUS DATA -->
            <div class="modal fade" id="ModalDel" tabindex="-1" role="dialog" aria-labelledby="DialogModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <h5 class="modal-title" id="ModalLabel01">
                               Menghapus Data
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p style="color: red; font-size: larger;text-align: center">Yakin menghapus data berikut..?</p>
                            <h3 id="nmusr" style="text-align: center; color: #d9534f"></h3>
                            <form id="form-userdel" method="POST" >
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <!--hidden ini akan terbawa ke method post di execute.php--> 
                                            <input type="hidden" name="usrid" id="usriddel">
                                            <input type="hidden" name="proc" value="usrdel">
                                        </div>                                    
                                    </div>
                                </div>        
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button onclick="deleteUser();" class="btn btn-danger" type="button" data-dismiss="modal">
                                Delete
                            </button>
                            <button class="btn btn-info" type="button" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AKHIR MODAL KONFIRMASI HAPUS DATA -->
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>                    
        <script>
            //prosedur untuk insert data ke tabel ketika tombol simpan di modal 
            //tambah atau edit data diklik
            //data yang telah di inputkan pada masing-masing field akan dibawa ke file
            //execute.php dan akan diproses berdasarkan kondisi percabangan yang ada
            function insertUser() {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: $("#form-tambahdata").serialize(),
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        if(data[0]==0){
                            alert(data[1]);
                        }else{
                            $("#userlist").html(data[1]);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
            
            //Prosedur ini akan dieksekusi ketika tombol delete pada modal konfirmasi
            //hapus data ditekan. 
            //kondisi di execute.php akan memproses query yang dikirim dari 
            //komponen yang di hidden dalam modal konfirmasi hapus data.
            function deleteUser() {
                $.ajax({
                    type: "POST",
                    url: "execute.php",
                    data: $("#form-userdel").serialize(),
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        //console.log(data);
                        if(data[0]==0){
                            alert(data[1]);
                        }else{
                            $("#userlist").html(data[1]);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
            
        </script>   

    </body>
</html>
