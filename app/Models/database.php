<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class database
{
    // singleton
    private static $instance = null;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new database();
        }
        return self::$instance;
    }
    public function check_login($username, $password)
    {
        $password = hash('sha256', $password);
        $result = DB::select('SELECT id FROM users WHERE username = ? AND password = ?', [$username, $password]);
        if (count($result) > 0) {
            return $result[0]->id;
        } else {
            return -1;
        }
    }
    public function get_user_info($id)
    {
        $result = DB::select('SELECT role, username, name, email, phone, avatar FROM users WHERE id = ?', [$id]);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }
    public function edit_user_info($id, $username, $name, $email, $phone, $avatar, $password)
    {
        $sql = "UPDATE users SET ";
        $param = array();
        if ($username != "") {
            $sql .= "username = ?, ";
            array_push($param, $username);
        }
        if ($name != "") {
            $sql .= "name = ?, ";
            array_push($param, $name);
        }
        if ($email != "") {
            $sql .= "email = ?, ";
            array_push($param, $email);
        }
        if ($phone != "") {
            $sql .= "phone = ?, ";
            array_push($param, $phone);
        }
        if ($avatar != "") {
            $sql .= "avatar = ?, ";
            array_push($param, $avatar);
        }
        if ($password != "") {
            $password = hash('sha256', $password);
            $sql .= "password = ?, ";
            array_push($param, $password);
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE id = ?";
        array_push($param, $id);
        if (DB::update($sql, $param) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function get_role($id)
    {
        $result = DB::select('SELECT role FROM users WHERE id = ?', [$id]);
        if (count($result) > 0) {
            return $result[0]->role;
        } else {
            return null;
        }
    }
    public function get_all_users()
    {
        $result = DB::select('SELECT id, username, name, email, phone, avatar, role FROM users');
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function get_chat($id1, $id2)
    {
        $result = DB::select('SELECT id, sender, (SELECT username FROM users WHERE users.id = sender) AS username, message FROM chat WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) ORDER BY created_at', [$id1, $id2, $id2, $id1]);
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function send_message($sender, $receiver, $message)
    {
        if (DB::insert('INSERT INTO chat (sender, receiver, message) VALUES (?, ?, ?)', [$sender, $receiver, $message]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function delete_message($id_user, $id)
    {
        if (DB::delete('DELETE FROM chat WHERE id = ? AND sender = ?', [$id, $id_user]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function edit_message($id_user, $id, $message)
    {
        if (DB::update('UPDATE chat SET message = ? WHERE id = ? AND sender = ?', [$message, $id, $id_user]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function teacher_upload_assignment($id_user, $title, $description, $file)
    {
        if (DB::insert('INSERT INTO assignments (teacher, title, description, file) VALUES (?, ?, ?, ?)', [$id_user, $title, $description, $file]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function student_upload_assignment($id_user, $assignment_id, $file)
    {
        if (DB::insert('INSERT INTO submissions (student, assignment_id, file) VALUES (?, ?, ?)', [$id_user, $assignment_id, $file]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function get_all_assignments()
    {
        $result = DB::select('SELECT id, (SELECT username FROM users WHERE users.id = teacher) AS poster, title FROM assignments');
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function get_assignment_detail($id)
    {
        $result = DB::select('SELECT (SELECT username FROM users WHERE users.id = teacher) AS poster, title, description, file FROM assignments WHERE id = ?', [$id]);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }
    public function get_all_submissions($id_user, $assignment_id)
    {
        if ($this->get_role($id_user) != "teacher") {
            $result = DB::select('SELECT (SELECT username FROM users WHERE users.id = student) AS poster, file, created_at FROM submissions WHERE assignment_id = ? AND student = ?', [$assignment_id, $id_user]);
        } else {
            $result = DB::select('SELECT (SELECT username FROM users WHERE users.id = student) AS poster, file, created_at FROM submissions WHERE assignment_id = ?', [$assignment_id]);
        }
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function get_all_riddles()
    {
        $result = DB::select('SELECT id, title, (SELECT username FROM users WHERE users.id = teacher) AS poster FROM riddles');
        if (count($result) > 0) {
            return $result;
        } else {
            return null;
        }
    }
    public function get_riddle_detail($id)
    {
        $result = DB::select('SELECT title, teacher, (SELECT username FROM users WHERE users.id = teacher) AS poster, description FROM riddles WHERE id = ?', [$id]);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }
    public function teacher_upload_riddle($id_user, $title, $description, $file)
    {
        if (DB::insert('INSERT INTO riddles (teacher, title, description, file) VALUES (?, ?, ?, ?)', [$id_user, $title, $description, $file]) == TRUE) {
            return true;
        } else {
            return false;
        }
    }
    public function check_riddle_submission($answer, $riddle_id)
    {
        $result = DB::select('SELECT * FROM riddles WHERE file = ? AND id = ?', [$answer, $riddle_id]);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>