<?php
if (isset($_POST['kode']) && $_POST['kode'] == 'amikomoke') {
    include 'koneksi.php';

    $nis = isset($_POST["nis"]) ? $_POST["nis"] : '';
    $password_siswa = isset($_POST["password_siswa"]) ? $_POST["password_siswa"] : '';

    if (empty($nis) || empty($password_siswa)) {
        $out['hasil'] = "gagal";
        $out['data'] = array();
        echo json_encode($out);
        exit;
    }

    $password_siswa = sha1($password_siswa);

    // Hindari SQL Injection dengan menambahkan escape string
    $nis = $db->real_escape_string($nis);
    $password_siswa = $db->real_escape_string($password_siswa);

    $ambil = $db->query("SELECT * FROM siswa WHERE nis='$nis' AND password_siswa='$password_siswa'");

    if ($ambil === false) {
        $out['hasil'] = "gagal";
        $out['data'] = array();
    } else {
        $siswa = $ambil->fetch_assoc();

        if (empty($siswa)) {
            $out['hasil'] = "gagal";
            $out['data'] = array();
        } else {
            $out['hasil'] = "sukses";
            $out['data'] = $siswa;
        }
    }
} else {
    $out['hasil'] = "gagal";
    $out['data'] = array();
}

echo json_encode($out);
?>