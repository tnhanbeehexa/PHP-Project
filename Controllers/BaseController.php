<?php

class BaseController {
    const VIEW_FOLDER_NAME = 'Views';
    const MODEL_FOLDER_NAME = 'Models';
   
    // Description:
    // + path name: folderName.fileName
    // + Lấy từ sau thư mục Views
    protected function view ($viewPath, $data = []) {
        foreach($data as $key => $val) {
            $$key = $val;
        }
        
        require self::VIEW_FOLDER_NAME . '/'  . str_replace('.', '/', $viewPath) . '.php';
    }

    protected function loadModel($modelPath) {
        require self::MODEL_FOLDER_NAME . '/'  . $modelPath . '.php';
        
    }

    protected function setSession($sessionName, $value) {
        session_start();
        return $_SESSION[$sessionName] = $value;
    }

    protected function alert($message) {
        echo "<script>alert('$message');</script>";

    }

    
}