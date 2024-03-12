<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class DownloadController extends Controller
{
    public function download($id_file) {
    $curUser = verifyJWT();
    if ($curUser === null) {
        return redirect('/login');
    }
    if (isset($_COOKIE['jwt_' . str_replace('.', '_', $id_file)])) {
        $jwt = $_COOKIE['jwt_' . str_replace('.', '_', $id_file)];
    } else {
        return redirect('/login');
    }
    $jwt = explode('.', $jwt);
    if (count($jwt) !== 3) {
        return redirect('/login');
    }
    $signature = hash_hmac('sha256', $jwt[0] . "." . $jwt[1], env('JWT_key'), true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    if ($base64UrlSignature !== $jwt[2]) {
        return redirect('/login');
    }
    $payload = json_decode(base64_decode($jwt[1]), true);
    $time = $payload['time'];
    if (time() - $time > 3600) {
        return redirect('/login');
    }
    $id = $payload['id'];
    if ($id_file !== $id) {
        return redirect('/login');
    }
    $file = env('STORAGE_DIR') . $id_file;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit();
    }
    else {
        return redirect('/login');
    }
    }
}
?>