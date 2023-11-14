<?php
    class RegisterModel extends BaseModel {
        const TABLE =  'users';
    

    public function addNewUser() {

    }
    
    public function addUser($user_name, $email, $password) {
        // Hash password before storing it
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . self::TABLE . " (user_name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("sss", $user_name, $email, $password);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function checkUserExists($user_name, $email) {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE user_name = ? OR email = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bind_param("ss", $user_name, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }
}
?>