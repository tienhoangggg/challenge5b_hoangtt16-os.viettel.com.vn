<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class ChatBoxController extends Controller
{
    public function index($id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            if($database->get_role($id)) {
                $chats = $database->get_chat($curUser['id'], $id);
                return view('chatBox', compact('chats', 'id', 'curUser'));
            }
            else {
                return redirect('/');
            }
        }
        else {
            return redirect('/login');
        }
    }

    public function send(Request $request, $id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            if($database->get_role($id)) {
                if($request->input('message')) {
                    $database->send_message($curUser['id'], $id, $request->input('message'));
                }
                return redirect('/chatBox/'.$id);
            }
            else {
                return redirect('/');
            }
        }
        else {
            return redirect('/login');
        }
    }

    public function edit(Request $request) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            if($request->input('isEdit')) {
                if($database->edit_message($curUser['id'], $request->input('id'), $request->input('message'))) {
                    return redirect('/chatBox/'.$request->input('id_user'));
                }
            }
        }
        return redirect('/login');
    }

    public function delete(Request $request) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            if($request->input('isDelete')) {
                if($database->delete_message($curUser['id'], $request->input('id'))) {
                    return redirect('/chatBox/'.$request->input('id_user'));
                }
            }
        }
        return redirect('/login');
    }
}
?>
