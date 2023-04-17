<?php
    class Database{
        private $server_name = "localhost"; //127.0.0.1
        private $username = "root";
        private $password = "root";
        private $db_name = "the_company";
        protected $conn;

        public function __construct(){
            $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

            if($this->conn->connect_error){
                die("unable to connect to the database ". $this->conn->connect_error);
            }
            
        }
    }



?>