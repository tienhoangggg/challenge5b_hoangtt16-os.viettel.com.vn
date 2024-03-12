<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\database;
require_once ("verifyJWT.php");

class AssignmentController extends Controller
{
    public function index() {
    $curUser = verifyJWT();
    if ($curUser) {
        $database = database::getInstance();
        $assignments = $database->get_all_assignments();
        return view('assignment', compact('assignments', 'curUser'));
    }
    return redirect('/login');
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
                    $allowed = array('pdf', 'doc', 'docx', 'txt', 'zip', 'rar', '7z');
                    if (in_array($fileExt, $allowed)) {
                        if ($fileSize < 10000000) {
                            $fileNameNew = hash('sha256', $curUser['id'] . rand(0,999999999) . rand(0,999999999) . rand(0,999999999)) . "." . $fileExt;
                            $file->move(env('STORAGE_DIR'), $fileNameNew);
                            if($database->teacher_upload_assignment($curUser['id'], $title, $description, $fileNameNew)) {
                                return redirect('/assignment');
                            } else {
                                return redirect('/assignment');
                            }
                        } else {
                            return redirect('/assignment');
                        }
                    } else {
                        return redirect('/assignment');
                    }
                }
                return redirect('/assignment');
            }
        }
        return redirect('/login');
    }
    public function detail($id) {
        $curUser = verifyJWT();
        if ($curUser) {
            $database = database::getInstance();
            $assignment = $database->get_assignment_detail($id);
            if($assignment) {
                $jwt = createJWT(array('id' => $assignment->file, 'time' => time()));
                setcookie('jwt_'.str_replace('.', '_', $assignment->file), $jwt, [
                    'expires' => time() + 3600,
                    'path' => '/download',
                    'domain' => '',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'strict'
                ]);
                $submissions = $database->get_all_submissions($curUser['id'], $id);
                if($submissions) {
                    foreach($submissions as $submission) {
                        $jwt = createJWT(array('id' => $submission->file, 'time' => time()));
                        setcookie('jwt_'.str_replace('.', '_', $submission->file), $jwt, [
                            'expires' => time() + 3600,
                            'path' => '/download',
                            'domain' => '',
                            'secure' => true,
                            'httponly' => true,
                            'samesite' => 'strict'
                        ]);
                    }
                }
                return view('assignmentDetail', compact('assignment', 'submissions', 'curUser', 'id'));
            }
        }
        return redirect('/login');
    }
    public function submit(Request $request, $id) {
        $curUser = verifyJWT();
        if ($curUser) {
            if($curUser['role'] == 'student') {
                $database = database::getInstance();
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileType = $file->getMimeType();
                $fileExt = $file->getClientOriginalExtension();
                $allowed = array('pdf', 'doc', 'docx', 'txt', 'zip', 'rar', '7z');
                if (in_array($fileExt, $allowed)) {
                    if ($fileSize < 10000000) {
                        $fileNameNew = hash('sha256', $curUser['id'] . rand(0,999999999) . rand(0,999999999) . rand(0,999999999)) . "." . $fileExt;
                        $file->move(env('STORAGE_DIR'), $fileNameNew);
                        if($database->student_upload_assignment($curUser['id'], $id, $fileNameNew)) {
                            return redirect('/assignmentDetail/' . $id);
                        } else {
                            return redirect('/assignmentDetail/' . $id);
                        }
                    } else {
                        return redirect('/assignmentDetail/' . $id);
                    }
                } else {
                    return redirect('/assignmentDetail/' . $id);
                }
            }
        }
        return redirect('/login');
    }
}
