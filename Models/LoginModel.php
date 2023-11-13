<?php

class LoginModel extends BaseModel {
    const TABLE = 'users';

    public function checkUserExists($user_name, $password) {
        $sql = "SELECT * FROM ". self::TABLE." WHERE user_name = '$user_name' AND password = '$password'";
        // die($sql);
        $result = $this->__query($sql);
        if($result && $result->num_rows >0) {
            return true;
        }else {
            return false;
        }
    }

    public function addUser($user_name, $email, $password) {
        // Hàm add user này đang sai bởi vì chưa checck được user_name và Passwrod, email đã tồn tại
        $sql = "INSERT INTO ". self::TABLE." VALUES ($user_name, $email, $password)";
        
        $this->__query($sql);

    }

    public function getUserId($user_name, $password) {
        $sql = "SELECT * FROM ". self::TABLE." WHERE user_name = '$user_name' AND password = '$password'";
        // die($sql);
        $result = $this->__query($sql);

        
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['user_id'];
            }
        }

        return false;
    }
}
?>