<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class InfoUserController extends Controller
{
    public function index($id) {
        $curUser = verifyJWT(); // Gọi hàm verifyJWT từ model
        $database = database::getInstance();
        $user = $database->get_user_info($id); // Gọi hàm get_user_info từ model
        $avatar = $user->avatar;
        if ($avatar == null) {
            $avatar = env('DEFAULT_AVATAR');
        }
        $data_avatar = base64_encode(file_get_contents(env('STORAGE_DIR').$avatar));
        return view('infoUser', compact('user', 'data_avatar', 'curUser', 'id'));
    }
    public function edit($id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            $user = $database->get_user_info($id); // Gọi hàm get_user_info từ model
            if ($curUser['id'] != $id && ($curUser['role'] !== 'teacher' || $user->role !== 'student'))
                return redirect('/');
            return view('editUser', compact('user', 'curUser', 'id'));
        }
        return redirect('/login');
    }
    public function update(Request $request, $id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $username = $request->input('username');
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $password = $request->input('password');
            $avatar = '';
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $target_file = env('STORAGE_DIR') . hash('sha256', $id) . "." . $file->extension();
                $file->move(env('STORAGE_DIR'), $target_file);
                $avatar = $target_file;
            }
            if ($curUser['role'] === 'student' && ($username != '' || $name != '')) {
                return redirect('/');
            }
            $database = database::getInstance();
            if ($database->edit_user_info($id, $username, $name, $email, $phone, $avatar, $password)) {
                return redirect('/infoUser/'.$id);
            }
        }
        return redirect('/login');
    }
}
