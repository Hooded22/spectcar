
<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
    	
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }

    public function select($query = "")
    {
        try {
            $stmt = $this->executeStatement( $query );
            if(mysqli_num_rows($stmt) == 0) {
                return false;
            } else {
                $result = $stmt->fetch_all(MYSQLI_ASSOC);	
            }

            return $result;
        } catch(Exception $e) {
            throw New Error( $e->getMessage() );
        }
        return false;
    }

    public function post($query) {
        try {
            $result = $this->executeStatement( $query );
            if($result == TRUE) {
                return $this->connection->insert_id;;
            }
            
            return $result;
        } catch(Exception $e) {
            throw New Error( $e->getMessage() );
        }
        return false;
    }

    public function executeStatement($query = "")
    {
        try {

            $result = $this->connection->query($query);

            return $result;
        } catch(Exception $e) {
            throw New Error( $e->getMessage() );
        }	
    }
}