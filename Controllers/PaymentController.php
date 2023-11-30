<?php
class PaymentController extends BaseController {
    private $paymentModel;
    public function __construct() {
        $this->loadModel('PaymentModel');
        $this->paymentModel = new PaymentModel();
    }

    public function index() {
        $data = $this->paymentModel->getPaymentStatusPendingApproval();
        $this->view('frontend.payments.index', [
            'data' => $data,
        ]);
        
    }

    public function showCartItemAwaitingConfirmation() {
        $data = $this->paymentModel->getPaymentStatusPendingApproval();

        return $this->view('frontend.payments.index', [
            'data' => $data,
        ]);
    }

    public function showCartItemWaitingDelivery() {
        $data = $this->paymentModel->getPaymentStatusPendingDelivery();
        $title = 'chào';
        return $this->view('frontend.payments.index', [
            'data' => $data,
            'title' => $title,
        ]);
    }
    
    public function showCartItemSuccessfullyPurchased() {
        $data = $this->paymentModel->getPaymentStatusSuccessfullyDelivery();
        $title = 'chào';
        return $this->view('frontend.payments.index', [
            'data' => $data,
            'title' => $title,
        ]);
    }
}


?>