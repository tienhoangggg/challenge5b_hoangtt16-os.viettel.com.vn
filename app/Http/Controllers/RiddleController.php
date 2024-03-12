<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class riddleController extends Controller
{
    public function index() {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            $riddles = $database->get_all_riddles();
            return view('riddle', compact('riddles', 'curUser'));
        }
    }
    public function create(Request $request) {
        $curUser = verifyJWT();
        if ($curUser) {
            if($curUser['role'] == 'teacher') {
                $database = database::getInstance();
                if($request->input('title') && $request->input('description')) {
                    $title = $request->input('title');
                    $description = $request->input('description');
                    $file = $request->file('file');
                    $fileName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $fileType = $file->getMimeType();
                    $fileExt = $file->getClientOriginalExtension();
                    $allowed = array('txt');
                    if (in_array($fileExt, $allowed)) {
                        if ($fileSize < 10000000) {
                            $fileNameNew = hash('sha256', $curUser['id'] . $title . $fileName) . "." . $fileExt;
                            $file->move(env('STORAGE_DIR'), $fileNameNew);
                            if($database->teacher_upload_riddle($curUser['id'], $title, $description, $fileNameNew)) {
                                return redirect('/riddle');
                            } else {
                                return redirect('/riddle');
                            }
                        } else {
                            return redirect('/riddle');
                        }
                    } else {
                        return redirect('/riddle');
                    }
                }
                return redirect('/riddle');
            }
        }
        return redirect('/login');
    }
    public function detail($id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            $riddles = $database->get_riddle_detail($id);
            if($riddles) {
                return view('riddleDetail', compact('riddles', 'curUser', 'id'));
            }
        }
        return redirect('/login');
    }
    public function submit(Request $request, $id) {
        $curUser = verifyJWT();
        if ($curUser) {
            if($curUser['role'] == 'student') {
                $database = database::getInstance();
                $fileName = $request->input('fileName') . ".txt";
                $teacher = $request->input('teacher');
                $title = $request->input('title');
                $answer = hash('sha256', $teacher . $title . $fileName) . ".txt";
                if($database->check_riddle_submission($answer, $id)) {
                    $jwt = createJWT(array("id" => $answer, "time" => time()));
                    setcookie('jwt_' . str_replace('.', '_', $answer), $jwt, [
                        'expires' => time() + 3600,
                        'path' => '/download',
                        'domain' => '',
                        'secure' => true,
                        'httponly' => true,
                        'samesite' => 'strict'
                    ]);
                    return redirect('/download/' . $answer);
                } else {
                    return redirect('/riddleDetail/' . $id);
                }
        }
        return redirect('/login');
        }
    }
}
