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
            $numPage = 0;
            $quantityOfButtonNumpage = $this->productModel->getQuantityOfNumpage()/6;
            if(isset($_GET['numpage'])) {
                $numPage = $_GET['numpage'];
            }
            $categories = $this->categories->getAllCategories();
            
            $products = $this->productModel->getAll($numPage);
            $pageTitle = 'Trang danh sách sản phẩm';
            
            if(isset($_GET['categoryId'])) {
                $products = $this->productModel->getProductsByCategoryId($_GET['categoryId'], $numPage);
                // echo '<prev>';
                // print_r($products);
                // echo '</prev>';
                // die();
            }

            return $this->view('frontend.products.index', [
                'pageTitle' => $pageTitle,
                'products' => $products,
                'categories' => $categories,
                'quantityOfButtonNumpage' => $quantityOfButtonNumpage
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

        public function showDetailProduct() {
            $product_id = $_GET['product_id'];
            $pageTitle = 'Chi tiết sản phẩm';

            $product = $this->productModel->getProductById($product_id);
            return $this->view('frontend.products.show', [
                'product' => $product,
                'pageTitle' => $pageTitle,
            ]);
        }

        public function search() {
            $search = $_GET['search'];
            $categories = $this->categories->getAllCategories();
            $pageTitle = 'Trang danh sách sản phẩm';



            $data = $this->productModel->search($search);
            return $this->view('frontend.products.search', [
                'pageTitle' => $pageTitle,
                'products' => $data,
                'categories' => $categories
            ]);
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