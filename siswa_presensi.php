<?php
if (isset($_POST['kode']) && $_POST['kode'] == 'amikomoke') {
    include 'koneksi.php';

    $nis = isset($_POST["nis"]) ? $_POST["nis"] : '';
    $kode_sesi = isset($_POST["kode_sesi"]) ? $_POST["kode_sesi"] : '';

    if (empty($nis) || empty($kode_sesi)) {
        $out['hasil'] = "gagal";
        $out['data'] = array();
        echo json_encode($out);
        exit;
    }

    $nis = $db->real_escape_string($nis);
    $kode_sesi = $db->real_escape_string($kode_sesi);

    $ambil = $db->query("SELECT * FROM siswa WHERE nis='$nis'");

    if ($ambil === false) {
        $out['hasil'] = "gagal";
        $out['data'] = array();
    } else {
        $siswa = $ambil->fetch_assoc();
        $ambil_sesi = $db->query("SELECT * FROM sesi WHERE kode_sesi = '$kode_sesi'");
        $sesi = $ambil_sesi->fetch_assoc();

        if (empty($sesi)) {
            $out['hasil'] = "gagal";
            $out['data'] = array();
        } else {
            $id_sesi = $sesi['id_sesi'];
            $ambil_presensi = $db->query("SELECT * FROM presensi WHERE id_sesi = '$id_sesi' AND nis = '$nis'");
            $presensi = $ambil_presensi->fetch_assoc();

            if (empty($presensi)) {
                $db->query("INSERT INTO presensi (id_sesi, nis) VALUES ('$id_sesi', '$nis')");
                $out['hasil'] = "sukses";
                $out['data'] = $siswa;
            } else {
                $out['hasil'] = "sudah";
                $out['data'] = $siswa;
            }
        }

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