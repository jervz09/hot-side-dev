<?php
session_start();
Class Actions {
    public $que;
    private $servername='localhost';
    private $username='root';
    private $password='root';
    private $dbname='hot-side';
    private $result=array();
    private $mysqli='';

    public function __construct(){
        $this->mysqli = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
    }

    function save_floorplan(){
        extract($_FILES);
        $resp['status'] = "failed";
        if(isset($fp) && !empty($fp['tmp_name'])){
            if(!is_dir(__DIR__."/uploads/"))
            mkdir(__DIR__."/uploads/");
            $fname = "/uploads/floorplan.png";
            $thumb_file = $fp['tmp_name'];
            $file_type = mime_content_type($thumb_file);
            list($width, $height) = getimagesize($thumb_file);
            $t_image = imagecreatetruecolor('1000', '800');
            if(in_array($file_type,array('image/png','image/jpeg','image/jpg'))){
                $gdImg = ($file_type =='image/png') ? imagecreatefrompng($thumb_file) : imagecreatefromjpeg($thumb_file);
                imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, '1000', '800', $width, $height);
                if($t_image){
                    if(is_file(__DIR__.$fname))
                        unlink(__DIR__.$fname);
                        $upload = imagepng($t_image,__DIR__.$fname);
                        imagedestroy($t_image);
                        if($upload){
                            $resp['status'] = "success";
                            $resp['msg'] = ' Floor Plan Successfully Updated.';
                    }
                }else{
                    $resp['msg'] = 'Floor Plan image has failed to upload.';
                }
            }else{
                    $resp['msg'] = 'Floor Plan image has failed to upload due to invalid file type.';
            }
        }
        return json_encode($resp);
    }
    function save_table(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        $check_sql = "SELECT count(table_id) as `count` FROM table_list where `table_no` = '{$table_no}' ".($id > 0 ? " and table_id != '{$id}' " : "");
        $check= $this->mysqli->query($check_sql);
        $check = mysqli_fetch_assoc($check)['count'];
        if($check> 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Table Number already exists.";
        }else{
            if(empty($id)){
                $sql = "INSERT INTO `table_list` {$data}";
            }else{
                $sql = "UPDATE `table_list` set {$data} where table_id = '{$id}'";
            }
            @$save = $this->mysqli->query($sql);
            if($save){
                $resp['status'] = 'success';
                if(empty($id))
                $resp['msg'] = 'Table Successfully added.';
                else
                $resp['msg'] = 'Table Details Successfully updated.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
                $resp['sql'] = $sql;
            }
        }
            return json_encode($resp);
    }
    function delete_table(){
        extract($_POST);
        @$delete = $this->mysqli->query("DELETE FROM `table_list` where table_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Table successfully deleted.';

        }else{
            $resp['status']='failed';
            $resp['msg'] = 'An error occure. Error: '.$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function save_reservation(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        $reservation_ts = strtotime($datetime);
        $reservation_ts_end = strtotime($datetime.' +3 hours');
        $sql_chl ="SELECT count(reservation_id) as `count` FROM reservation_list where `table_id` = '{$table_id}' and ('{$reservation_ts}' BETWEEN strftime('%s',`datetime`) and strftime('%s',DATETIME(`datetime`,'+3 hours')) OR '{$reservation_ts_end}' BETWEEN strftime('%s',`datetime`) and strftime('%s',DATETIME(`datetime`,'+3 hours')) ) ".($id > 0 ? " and reservation_id != '{$id}' " : "") ;
        @$check= $this->query($sql_chl)->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Table is not available on the selected date and time.";
        }else{
            if(empty($id)){
                $sql = "INSERT INTO `reservation_list` {$data}";
            }else{
                $sql = "UPDATE `reservation_list` set {$data} where reservation_id = '{$id}'";
            }
            @$save = $this->query($sql);
            if($save){
                $resp['status'] = 'success';
                if(empty($id))
                $resp['msg'] = 'Reservation Successfully added.';
                else
                $resp['msg'] = 'Reservation Details Successfully updated.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
                $resp['sql'] = $sql;
            }
        }
            return json_encode($resp);
    }
    function delete_reservation(){
        extract($_POST);
        @$delete = $this->mysqli->query("DELETE FROM `reservation_list` where reservation_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Reservation successfully deleted.';

        }else{
            $resp['status']='failed';
            $resp['msg'] = 'An error occure. Error: '.$this->lastErrorMsg();
        }
        return json_encode($resp);
    }

    function user_reservation(){
        extract($_POST);
        $data = "";
        $reservation_id = 0;
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        if(empty($id)){
            $sql = "INSERT INTO `reservation_list` {$data}";
        }else{
            $sql = "UPDATE `reservation_list` set {$data} where reservation_id = '{$id}'";
            $reservation_id = $id;
        }
        @$save = $this->mysqli->query($sql);
        // $save = true;
        if($save){
            $resp['status'] = 'success';
            $resp['reservation_id'] = $this->mysqli->insert_id;
            if(empty($id)){
                $resp['msg'] = 'Reservation Successfully added.';
            }else{
                $resp['msg'] = 'Reservation Details Successfully updated.';
            }
        $_SESSION['flashdata']['type'] = 'success';
        $_SESSION['flashdata']['msg'] = $resp['msg'];
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
            $resp['sql'] = $sql;
        }
        return json_encode($resp);
    }

    function order_menu(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v) && !is_array($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(is_array($v)){
                    $v = implode(", ",$v);
                }
                if(empty($id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        if(empty($id)){
            $sql = "INSERT INTO `menu_order_list` {$data}";
        }else{
            $sql = "UPDATE `menu_order_list` set {$data} where reservation_id = '{$id}'";
        }
        @$save = $this->mysqli->query($sql);
        if($save){
            $resp['status'] = 'success';
            if(empty($id))
            $resp['msg'] = 'Order Successfully added.';
            else
            $resp['msg'] = 'Reservation Details Successfully updated.';
        $_SESSION['flashdata']['type'] = 'success';
        $_SESSION['flashdata']['msg'] = $resp['msg'];
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
            $resp['sql'] = $sql;
        }
        // }
        return json_encode($resp);
    }

    function update_reservation_status(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($reservation_id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        $check_sql = "SELECT * FROM `reservation_list` where reservation_id = '{$reservation_id}'";
        $check= $this->mysqli->query($check_sql);
        $check = mysqli_num_rows($check);
        if($check< 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Reservation Not Found.";
        }else{
            $sql = "UPDATE `reservation_list` set {$data} where reservation_id = '{$reservation_id}'";
            @$save = $this->mysqli->query($sql);
            if($save){
                $resp['status'] = 'success';
                $resp['msg'] = 'Reservation Successfully updated.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
                $resp['sql'] = $sql;
            }
        }
        return json_encode($resp);
    }

    function add_menu(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($menu_id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        $check_sql = "SELECT * FROM `menu_list` where menu_id = '{$menu_id}'";
        $check= $this->mysqli->query($check_sql);
        $check = mysqli_num_rows($check);
        if($check< 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Reservation Not Found.";
        }else{
            $sql = "UPDATE `menu_list` set {$data} where menu_id = '{$menu_id}'";
            @$save = $this->mysqli->query($sql);
            if($save){
                $resp['status'] = 'success';
                $resp['msg'] = 'Reservation Successfully updated.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
                $resp['sql'] = $sql;
            }
        }
        return json_encode($resp);
    }

    function update_menu(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($menu_id)){
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        if(empty($menu_id)){
            $sql = "INSERT INTO `menu_list` {$data}";
        }else{
            $sql = "UPDATE `menu_list` set {$data} where menu_id = '{$menu_id}'";
        }
        @$save = $this->mysqli->query($sql);
        if($save){
            $resp['status'] = 'success';
            $resp['msg'] = 'Reservation Successfully recorded.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
            $resp['sql'] = $sql;
        }
        return json_encode($resp);
    }

    function delete_menu(){
        extract($_POST);
        @$delete = $this->mysqli->query("DELETE FROM `menu_list` where menu_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Menu successfully deleted.';

        }else{
            $resp['status']='failed';
            $resp['msg'] = 'An error occure. Error: '.$this->lastErrorMsg();
        }
        return json_encode($resp);
    }

    function validate_update_password(){
        extract($_POST);
        $is_success = false;
        if($current_password == $password){
            $resp['status']='failed';
            $resp['msg'] = 'Password must differ from old password.';
            return json_encode($resp);
        }
        if($re_password !== $password){
            $resp['status']='failed';
            $resp['msg'] = 'Your password and re-type password must match.';
            return json_encode($resp);
        }
        @$user = $this->mysqli->query("SELECT * FROM users WHERE user_id = $user_id");
        $check = mysqli_fetch_assoc($user);
        if (password_verify($current_password, $check['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $save = $this->mysqli->query("UPDATE `users` set `password` = '$password' where user_id = '$user_id'");
            if($save){
                $resp['status'] = 'success';
                $resp['msg'] = 'Update password.';
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = $resp['msg'];
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
                $resp['sql'] = $sql;
            }
            return json_encode($resp);
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'Incorrect current password.';
        }
        return json_encode($resp);
    }


    function update_user(){
        extract($_POST);
        $data = "";
        @$profile_img = $_SESSION['profile_img'] ?? "";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!is_numeric($v)){
                    $v = $this->mysqli->real_escape_string($v);
                }
                if(empty($user_id)){
                    if($k == "password"){
                        $v = password_hash($v, PASSWORD_DEFAULT);
                    }
                    $columns[] = "`{$k}`";
                    $values[] = "'{$v}'";
                }else{
                    if(!empty($data)) $data .= ", ";
                    $data .= " `{$k}` = '{$v}'";
                }
            }
        }
        if(isset($columns) && isset($values)){
            $data = "(".(implode(",",$columns)).") VALUES (".(implode(",",$values)).")";
        }
        if(empty($user_id)){
            $sql = "INSERT INTO `users` {$data}";
        }else{
            $sql = "UPDATE `users` set {$data} where user_id = '{$user_id}'";
        }
        // echo $sql;
        @$save = $this->mysqli->query($sql);
        if($save){
            $resp['status'] = 'success';
            $resp['msg'] = 'User Successfully recorded.';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = $resp['msg'];
            $_SESSION['first_name'] = isset($first_name) ? $first_name : $_SESSION['first_name'];
            $_SESSION['last_name'] = isset($last_name) ? $last_name : $_SESSION['last_name'];
            $_SESSION['username'] = isset($username) ? $username : $_SESSION['username'];
            $_SESSION['contact_no'] = isset($contact_no) ? $contact_no : $_SESSION['contact_no'];
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occured. Error: '.$this->lastErrorMsg();
            $resp['sql'] = $sql;
        }
        if($_SESSION['id'] == $user_id && $profile_img){
            $_SESSION['profile_img'] = isset($profile_img) ?: $profile_img;
        }
        return json_encode($resp);
    }

    function delete_user(){
        extract($_POST);
        @$delete = $this->mysqli->query("DELETE FROM `users` where user_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Menu successfully deleted.';

        }else{
            $resp['status']='failed';
            $resp['msg'] = 'An error occure. Error: '.$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$action = new Actions();
switch($a){
    case 'save_floorplan':
        echo $action->save_floorplan();
    break;
    case 'save_table':
        echo $action->save_table();
    break;
    case 'delete_table':
        echo $action->delete_table();
    break;
    case 'save_reservation':
        echo $action->save_reservation();
    break;
    case 'user_reservation':
        echo $action->user_reservation();
    break;
    case 'delete_reservation':
        echo $action->delete_reservation();
    break;
    case 'update_reservation_status':
        echo $action->update_reservation_status();
    break;
    case 'order_menu':
        echo $action->order_menu();
    break;
    case 'add_menu':
        echo $action->add_menu();
    break;
    case 'update_menu':
        echo $action->update_menu();
    break;
    case 'delete_menu':
        echo $action->delete_menu();
    break;
    case 'update_user':
        echo $action->update_user();
    break;
    case 'delete_user':
        echo $action->delete_user();
    break;
    case 'validate_update_password':
        echo $action->validate_update_password();
    break;
    default:
    // default action here
    break;
}