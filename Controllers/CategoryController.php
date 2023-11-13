<?php
    class CategoryController extends BaseController{
        private $category;
        public function __construct() {
            $this->loadModel('CategoryModel');
            $this->category = new CategoryModel();
        }
        public function index() {
            $categories = $this->category->getAllCategories();
            // echo '<prev>';
            // print_r($result);
            // echo '</prev>';
            // echo __METHOD__;
            return $this->view('frontend.products.index', [
                'categories' => $categories,
            ]);
        }

        public function show() {
            echo __METHOD__;
        }
    }
?>