<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class AuthController extends Controller
{
    public function index() {
        return view('login');
    }
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $database = database::getInstance();
        $username = $request->input('username');
        $password = $request->input('password');
        $id = $database->check_login($username, $password);
    if ($id != -1) {
        $jwt = createJWT(array("id" => $id, "time" => time()));
        setcookie('jwt', $jwt, [
            'expires' => time() + 7200,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict'
        ]);
        return redirect('/');
    } else {
        return redirect('/login');
    }
    }
    public function logout() {
        setcookie("jwt", "", time() - 3600, "/");
        return redirect('/login');
    }
}
