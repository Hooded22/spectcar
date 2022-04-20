<?php
    class TransactionModel extends Database {
        public function getAll() {
            $query = "SELECT * FROM transactions";
            return $this->select($query);
        }
    }