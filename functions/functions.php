<?php

define('base_url', 'https://dev.griyouwuh.com/api/');
// define('base_url', 'http://localhost/griyouwuh/api/');

//buat enkripsi password
function encryptPass($pass)
{
    $key = mb_convert_encoding($pass, 'UTF-8');
    $bytes = mb_convert_encoding('xH@xl4Lx', 'UTF-8');
    // $key = utf8_encode($pass);
    // $bytes = utf8_encode('xH@xl4Lx');
    $digest = hash_hmac('sha256', $key, $bytes);
    return strval($digest);
}

// Get total organik global ton
function getOrganikGlobalTon()
{
    $url = base_url . 'total-organik-ton';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $organikTon = $data["data"][0];
    return $organikTon;
}

// Get total anorganik global ton
function getAnorganikGlobalTon()
{
    $url = base_url . 'total-anorganik-ton';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $anorganikTon = $data["data"][0];
    return $anorganikTon;
}

// Get total user
function getTotalUser()
{
    $url = base_url . 'total-user';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $total_user = $data["data"][0]["total_user"];
    return $total_user;
}

// Get total setoran aktif/pending
function getTotalSetoranPending()
{
    $url = base_url . 'total-setoran-pending';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $totalSetoranPending = $data["data"][0]["setoran_pending"];
    return $totalSetoranPending;
}

// Get total setoran done
function getTotalSetoranDone()
{
    $url = base_url . 'total-setoran-done';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $totalSetoranDone = $data["data"][0]["setoran_done"];
    return $totalSetoranDone;
}

// Get total user gratis
function getTotalUserGratis()
{
    $url = base_url . 'total-user-gratis';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $userGratis = $data["data"][0]["user_gratis"];
    return $userGratis;
}

// Get total user berbayar
function getTotalUserBerbayar()
{
    $url = base_url . 'total-user-berbayar';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $userBerbayar = $data["data"][0]["user_berbayar"];
    return $userBerbayar;
}

// Get data all user
function getUsers()
{
    $url = base_url . 'users';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $users = [];
    $users = $data["data"];
    return $users;
}

// Get data user
function getUser($id)
{
    $url = base_url . "users?id_user=$id";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $user = [];
    $user = $data["data"][0];
    return $user;
}

// Get data user
function deleteUser($id)
{
    $url = base_url . "delete-user?id_user=$id";

    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // $response = curl_exec($curl);
    // curl_close($curl);
    // return json_decode($response, true);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $status = [];
    $status = $data["status"];
    return $status;
}

// Get data ranking all user
function getRankUsers()
{
    $url = base_url . 'peringkat-alluser';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $rankUsers = [];
    $rankUsers = $data["data"];
    return $rankUsers;
}

// Get data tracking organik
function getTrackingOrganik()
{
    $url = base_url . 'tracking-organik';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $trackingOrganik = [];
    $trackingOrganik = $data["data"];
    return $trackingOrganik;
}

// Get data tracking anorganik
function getTrackingAnorganik()
{
    $url = base_url . 'tracking-anorganik';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $trackingAnorganik = [];
    $trackingAnorganik = $data["data"];
    return $trackingAnorganik;
}


// Get data setoran done
function getSetoranDone()
{
    $url = base_url . 'setoran-done';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $setoranDone = [];
    $setoranDone = $data["data"];
    return $setoranDone;
}

// Get data setoran done user
function getSetoranDoneUser($id)
{
    $url = base_url . "setoran-done?id_setoran=$id";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $setoranDone = [];
    $setoranDone = $data["data"][0];
    return $setoranDone;
}

// Get data setoran pending
function getSetoranPending()
{
    $url = base_url . 'setoran-pending';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $setoranPending = [];
    $setoranPending = $data["data"];
    return $setoranPending;
}

// Get data setoran pending user
function getSetoranPendingUser($id)
{
    $url = base_url . "setoran-pending?id_setoran=$id";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $setoranPending = [];
    $setoranPending = $data["data"][0];
    return $setoranPending;
}

//update data setoran
function updateSetoran($id, $jenis, $ton, $kg, $ons, $gram)
{
    $url = base_url . 'update-setoran';
    $data = [
        'id_setoran' => "$id",
        'jenis_sampah' => "$jenis",
        'ton' => "$ton",
        'kg' => "$kg",
        'ons' => "$ons",
        'gram' => "$gram"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}

//update data setoran done
function updateSetoranDone($id, $jenis, $ton, $kg, $ons, $gram, $bobotLama)
{
    $url = base_url . 'update-setoran-done';
    $data = [
        'id_setoran' => "$id",
        'jenis_sampah' => "$jenis",
        'ton' => "$ton",
        'kg' => "$kg",
        'ons' => "$ons",
        'gram' => "$gram",
        'bobotLama' => "$bobotLama"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}


// add user
function addUser($nama, $email, $telp, $pass, $alamat, $jenis_pelanggan)
{
    $finalPass = encryptPass($pass);

    $url = base_url . 'signup-by-admin';
    $data = [
        'nama' => "$nama",
        'email' => "$email",
        'telp' => "$telp",
        'pass' => "$finalPass",
        'alamat' => "$alamat",
        'jenis_pelanggan' => "$jenis_pelanggan"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}



//cek user by email
function cekUserEmail($email, $pass)
{
    $finalPass = encryptPass($pass);

    $url = base_url . "login?email=$email&pass=$finalPass";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $status = $data["status"];
    return $status;
    // return $finalPass;
}

//cek user by telp
function cekUserTelp($telp, $pass)
{
    $finalPass = encryptPass($pass);
    $url = base_url . "login?telp=$telp&pass=$finalPass";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $status = $data["status"];
    return $status;
}

//verif ubah data pengguna
function verifUbahData($id, $emailtelp, $passLama)
{
    if ((cekUserEmail("$emailtelp", $passLama) == 1 || cekUserTelp($emailtelp, $passLama) == 1)) {
        return $id;
    } else {
        echo "<script>alert('Data anda masukkan salah!')</script>";
    }
}


// update tracking organik
function updateTrackingOrganik($tahap, $ton, $kg, $ons, $gram)
{
    $url = base_url . 'update-tracking-organik';
    $data = [
        'tahap' => "$tahap",
        'ton' => "$ton",
        'kg' => "$kg",
        'ons' => "$ons",
        'gram' => "$gram"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}

// update tracking anorganik
function updateTrackingAnorganik($tahap, $ton, $kg, $ons, $gram)
{
    $url = base_url . 'update-tracking-anorganik';
    $data = [
        'tahap' => "$tahap",
        'ton' => "$ton",
        'kg' => "$kg",
        'ons' => "$ons",
        'gram' => "$gram"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}

// login admin
function loginAdmin($id, $pass)
{
    $finalPass = encryptPass($pass);

    $url = base_url . "login?id_admin=$id&pass=$finalPass";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    if ($data["status"] == 1) {
        $data = $data["data"]["id_admin"];
        return $data;
    } else {
        return false;
    }
}

// Get data riwayat organik
function getRiwayatOrganikBulan($year)
{

    $url = base_url . "riwayat-organik?year=$year";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $riwayatOrganik = [];
    $riwayatOrganik = $data["data"];
    return $riwayatOrganik;
}

// Get data riwayat anorganik
function getRiwayatAnorganikBulan($year)
{

    $url = base_url . "riwayat-anorganik?year=$year";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $riwayatAnorganik = [];
    $riwayatAnorganik = $data["data"];
    return $riwayatAnorganik;
}


//update data user
function updateDataUSer($id, $nama, $email, $telp, $pass, $alamat, $jenis_pelanggan)
{
    $finalPass = encryptPass($pass);

    $url = base_url . "update-user-byadmin?id_user=$id";
    $data = [
        'nama' => "$nama",
        'email' => "$email",
        'telp' => "$telp",
        'pass' => "$finalPass",
        'alamat' => "$alamat",
        'jenis_pelanggan' => "$jenis_pelanggan"
    ];

    // use key 'http' even if you send the request to https://...
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) {
        /* Handle error */
    }

    return $result;
}

//cek email
function cekEmailUser($email)
{
    $url = base_url . "cek-email-telp?email=$email";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $result = [];
    $result = $data["status"];
    return $result;
}

//cek email
function cekTelpUser($telp)
{
    $url = base_url . "cek-email-telp?telp=$telp";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    $result = [];
    $result = $data["status"];
    return $result;
}
