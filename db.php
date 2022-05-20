<?php
    define('HOST','127.0.0.1');
    define('USER','root');
    define('PASS','');
    define('DB','baitaplon');

    function open_database(){
        $conn = new mysqli(HOST,USER,PASS,DB);
        if($conn->connect_error){
            die('Connect error: '.$conn->connect_error);
        }
        return $conn;
    }

    function is_email_exists($email){
        $sql = 'SELECT email from user where email = ?';
        $conn = open_database();
    
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()) {
            die('Query error: ' . $stm->error);
        }
    
        $result = $stm->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function is_phone_exists($phone){
        $sql = 'SELECT phone from user where phone = ?';
        $conn = open_database();
    
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $phone);
        if (!$stm->execute()) {
            die('Query error: ' . $stm->error);
        }
    
        $result = $stm->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    function register($user, $birth, $email,$address ,$phone){

        if (is_email_exists($email)) {
            return array('code' => 1, 'error' => 'Email exists');
        }

        if (is_phone_exists($phone)) {
            return array('code' => 3, 'error' => 'Phone exists');
        }
        $sql = 'INSERT INTO USER(name,date,email,address,phone) values(?,?,?,?,?)';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssi',$user, $birth, $email,$address ,$phone);
        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Can not execute command');
        }
        return
            array('code' => 0, 'error' => 'Create account successful');
    }
?>