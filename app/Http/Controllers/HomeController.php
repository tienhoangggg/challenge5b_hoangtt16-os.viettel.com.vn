<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class HomeController extends Controller
{
    public function index() {
        if (isset($_COOKIE['jwt'])) {
            //check user is exist
            $curUser = verifyJWT();
            if ($curUser) {
            $database = database::getInstance();
            $users = $database->get_all_users();
            return view('home', compact('users'));
            }
        }
        return redirect('/login');
    }
}
