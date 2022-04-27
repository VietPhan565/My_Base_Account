<?php
    class User{
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        public function getUsers(){
            $this->db->query('select * from user');

            $result = $this->db->resultSet();

            return $result;
        }
    }
?>