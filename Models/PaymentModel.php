<?php
class PaymentModel extends BaseModel {
    const TABLE = 'payment';

    public function getAllPayments() {

    }

    public function getPaymentStatusPendingApproval() {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }
        $user_id =  $_SESSION['user_id'];
        $sql = "SELECT *
        FROM cart_items ci
        INNER JOIN Payment p ON ci.payment_id = p.payment_id
        INNER JOIN Carts c ON ci.cart_id = c.cart_id
        WHERE ci.cart_item_status = 'pending approval' 
            AND p.payment_status = 'pending approval' 
        AND c.user_id = $user_id";
        // die($sql);
        $result = $this->__query($sql);
        $data = [];
        if($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               array_push($data, $row);
            }
        }

        return $data;
    }

    public function getPaymentStatusPendingDelivery() {
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $user_id =  $_SESSION['user_id'];
        $sql = "SELECT *
        FROM cart_items ci
        INNER JOIN Payment p ON ci.payment_id = p.payment_id
        INNER JOIN Carts c ON ci.cart_id = c.cart_id
        WHERE ci.cart_item_status = 'delivery' 
            AND p.payment_status = 'delivery' 
            AND c.user_id = $user_id";
        // die($sql);
        $result = $this->__query($sql);
        $data = [];
        if($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               array_push($data, $row);
            }
        }
        return $data;
    }
    

    public function getPaymentStatusSuccessfullyDelivery() {
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $user_id =  $_SESSION['user_id'];
        $sql = "SELECT *
        FROM cart_items ci
        INNER JOIN Payment p ON ci.payment_id = p.payment_id
        INNER JOIN Carts c ON ci.cart_id = c.cart_id
        WHERE ci.cart_item_status = 'successful delivery' 
            AND p.payment_status = 'successful delivery' 
            AND c.user_id = $user_id";
        // die($sql);
        $result = $this->__query($sql);
        $data = [];
        if($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               array_push($data, $row);
            }
        }
        return $data;
    }
}

?>