<?php
    class ProductController extends BaseController{
        private $productModel;
        private $categories;
        public function __construct()
        {
            $this->loadModel('ProductModel');
            $this->loadModel('CategoryModel');
            $this->productModel = new ProductModel();
            $this->categories = new CategoryModel();
        }

        // Danh sách sản phẩm
        public function index() {
            $categories = $this->categories->getAllCategories();
            // echo '<prev>';
            // print_r($categories);
            // echo '</prev>';
            $products = $this->productModel->getAll();
            $pageTitle = 'Trang danh sách sản phẩm';
            
            if(isset($_GET['categoryId'])) {
                $products = $this->productModel->getProductsByCategoryId($_GET['categoryId']);
                // echo '<prev>';
                // print_r($products);
                // echo '</prev>';
                // die();
            }

            return $this->view('frontend.products.index', [
                'pageTitle' => $pageTitle,
                'products' => $products,
                'categories' => $categories
            ]);
        }

        public function store()
        {
            $data = [
                'name' => "Iphone 12",
                'price' => 1500000,
                'image' => 'Không có hình ảnh',
                'category_id' => '4'
            ];

            $this->productModel->store($data);
        }

       
        public function show() {
            // $product =  $this->productModel->findById(1);
            $title = 'Show danh sách sản phẩm';
            return $this->view('frontend.products.show', [
                'title' => $title,
                // 'product' => $product,
            ]);
            // return $this->view('frontend.products.show',);
        }

        public function update()
        {
            $id = $_GET['id'];
            $data = [
                'name' => "Iphone 15",
                'price' => 1500000,
                'image' => 'Không có hình ảnh',
                'category_id' => '4'
            ];

            $this->productModel->updateData($id, $data);
        }

        public function delete() 
        {
            $id = $_GET['id'];
            $this->productModel->destroy($id);
        }

        public function showProductByCategory() {
            echo __METHOD__;
        }
    }
?>