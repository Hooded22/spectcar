<?php
    class UserModel extends Database {
        public function getAllUsers() {
            $query = "SELECT * FROM users";
            return $this->select($query);
        }

        public function getById($id) {
            $query = "SELECT * FROM users WHERE id=$id";
            return $this->select($query);
        }

        public function getByLogin($login) {
            $query = "SELECT * FROM users WHERE `login` LIKE '$login'";
            return $this->select($query);
        }

        public function getByToken($token) {
            $query = "SELECT * FROM users WHERE `token` LIKE '$token'";
            return $this->select($query);
        }


        public function addUser($login, $email, $name, $lastName, $password) {
            $query = "INSERT INTO 
            `users` (`id`, `login`, `email`, `name`, `last_name`, `password`, `token`, `token_expire_date`, `type`) 
            VALUES (NULL, '$login', '$email', '$name', '$lastName', '$password', NULL, current_timestamp(), NULL)
            ";
            return $this->executeStatement($query);
        }

        public function updateUser($values, $id) {
            $fieldAndValuesStr = "";
            $index = 0;
            foreach($values as $key => $value) {
                $fieldAndValuesStr = $fieldAndValuesStr."`$key`='$value'";
                if($index != count($values) - 1) {
                    $fieldAndValuesStr = $fieldAndValuesStr.", ";
                }
                $index++;
            }
            $query = "UPDATE `users` SET ".$fieldAndValuesStr." WHERE `users`.`id` = $id";
            $result = $this->executeStatement($query);
            if($result != FALSE)
            {
               return $this->getById($id);
            }
            return $result;
            
        }
    }
?>