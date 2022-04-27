<?php

    class Pages extends Controller{
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function index(){
            $user = $this->userModel->getUsers();

            $data = [
                'user' => $user
            ];

            $this->view('pages/index');
        }

        public function about(){
            $this->view('pages/about');
        }
    }

?>