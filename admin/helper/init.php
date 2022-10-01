<?php
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
        @$delete = $this->query("DELETE FROM `reservation_list` where reservation_id = '{$id}'");
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
    function update_reservation_status(){
        extract($_POST);
        $get = $this->query("SELECT * FROM `reservation_list` where reservation_id = '{$reservation_id}'");
        $update = $this->query("UPDATE `reservation_list` set `status` = '{$status}' where reservation_id = '{$reservation_id}'");
        if($update){
            $resp['status'] = 'success';
            $resp['msg'] = "Reservation Status successfully updated";
            $resp['return_status'] = $status;
            $res= $get->fetchArray();
            if($status == 2){
                $this->query("UPDATE `table_list` set `status` = 0  where table_id = '{$res['table_id']}'");
            }else{
                $now =strtotime(date("Y-m-d H:i"));
                $check = $this->query("SELECT count(reservation_id) FROM reservation_list where table_id =  '{$res['table_id']}' and ('{$now}' BETWEEN strftime('%s',`datetime`) and strftime('%s',DATETIME(`datetime`,'+3 hours')) ) and reservation_id != '{$reservation_id}' ")->fetchArray()[0];
                if($check > 0){
                    $this->query("UPDATE `table_list` set `status` = 0  where table_id = '{$res['table_id']}'");
                }else{
                    $this->query("UPDATE `table_list` set `status` = 1  where table_id = '{$res['table_id']}'");
                }
            }
        }else{
            $resp['status'] ='failed';
            $resp['msg'] = "An error occured while updating data. Error: ".$this->lastErrorMsg();
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
    case 'delete_reservation':
        echo $action->delete_reservation();
    break;
    case 'update_reservation_status':
        echo $action->update_reservation_status();
    break;
    default:
    // default action here
    break;
}