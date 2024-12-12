<?php
if (isset($_POST['kode']) && $_POST['kode'] == 'amikomoke') {
    include 'koneksi.php';

    $nis = $_POST["nis"];
    $password_siswa = sha1($_POST["password_siswa"]);

    // $db -> array();
    $ambil = $db->query("SELECT * FROM siswa WHERE nis='$nis' AND password_siswa='$password_siswa'");
    $siswa = $ambil->fetch_assoc();

    if (empty($siswa)) {
        $out['hasil'] = "gagal";
        $out['data'] = array();
    } else {
        $out['hasil'] = "sukses";
        $out['data'] = $materi;
    }

    // while ($tiap = $ambil->fetch_assoc()) {
    //     $materi[] = $tiap;
    // }
} else {
    $out['hasil'] = "gagal";
    $out['data'] = array();
}

echo json_encode($out);
