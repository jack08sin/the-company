<?php

    require_once 'Database.php';

    # We need to inherit the database.php because we will use the $this->conn(object)
    # to connect to our database

    class User extends Database{
        //most of our methods/logic will be here e.g CRUD -- Create, Read, Update, Delete

        # Method store registration details to the database
        public function store($request){
            $first_name = $request['first_name'];
            $last_name  = $request['last_name'];
            $username   = $request['username'];
            $password   = $request['password'];

            # Encrypt the password
            $password = password_hash($password, PASSWORD_DEFAULT);

            # SQL QUERY STRING
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) 
                    VALUES('$first_name', '$last_name', '$username', '$password')";

                    if ($this->conn->query($sql)){
                        header('location: ../views');  //go to index.php
                        exit();
                    } else{
                        die ("Error in creating user: " .$this->conn->error);
                    }
        }

        public function login($request){
            $username = $request['username'];
            $password = $request['password'];

            # Query string
            $sql = "SELECT * FROM users WHERE username='$username'";

            $result = $this->conn->query($sql);

            #check the username
            if($result->num_rows == 1){  // if this is true, then username is available
                #check the password if correct
                $user = $result->fetch_assoc();

                //$user = ['id' => 1, 'username' => 'john', 'password' => '$2y$10$c9'....]
                
                #Verify the password if matched
                if(password_verify($password, $user['password'])){ // If true, then 
                    # Create a session variables
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name']= $user['first_name'] ." ". $user['last_name'];

                    header('location: ../views/dashboard.php');
                    exit;
                } else{
                    die('Password is incorrect');
                }
             } else{
                die('Username not found');
             }
        }

        public function logout(){
            session_start();
            session_unset();
            session_destroy();

            header('location: ../views'); //index.php
            exit;
        }

        # Retrieved all the users in the table
        public function getAllUsers(){
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";
            if($result = $this->conn->query($sql)){
                return $result;
            } else{
                die("Error in retrieving users ". $this->conn->error);
            }
        }

        #Retrieve only 1 user specifically
        public function getUser(){
            // session_start();
            $id = $_SESSION['id']; //global in scope, so that is why we can use it here    //the id of the user who is currently logged-in
        
            $sql = "SELECT id, first_name, last_name, username, photo FROM users WHERE id=$id";

            if($result = $this->conn->query(($sql))){
                return $result->fetch_assoc();
            } else{
                die('Error retrieving user' . $this->conn->error);
            }
        }

        public function update($request, $files){
            session_start();
            $id = $_SESSION['id']; // coming from the login method session variable
            $first_name = $request['first_name'];
            $last_name  = $request['last_name'];
            $username   = $request['username'];
            $photo      = $files['photo']['name'];
            $tmp_photo  = $files['photo']['tmp_name'];

            # create the query string
            $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id=$id";

            # Execute the query above
            if($this->conn->query($sql)){
                #set the new session variable below, if the query above doesn't have any error
                $_SESSION['username'] = $username;
                $_SESSION['full_name']= "$first_name $last_name";

                # check if there is an image uploaded and save it to the images folder
                if($photo){
                    $sql = "UPDATE users SET photo = '$photo' WHERE id=$id";
                    $destination = "../assets/images/$photo";

                    # save the image name to the database table
                    if($this->conn->query($sql)){
                        // Save or move the file to the images folder
                        if(move_uploaded_file($tmp_photo, $destination)){
                            header('location: ../views/dashboard.php');
                            exit;
                        } else{
                            die("Error in moving the photo.");
                        }
                    } else{
                        die("Error in uploading the photo: ".$this->conn->error);
                    }
                }
                
                header('location: ../views/dashboard.php');
               
            } else{
                die("Error in updating the user details: ".$this->conn->error);
            }
        }

        public function delete(){
            session_start();
            $id = $_SESSION['id'];

            $sql = "DELETE FROM users WHERE id = $id";

            if($this->conn->query($sql)){
                $this->logout();
            } else{
                die("Error in deleting your account: ".$this->conn->error);
            }
        }
    }

?>