<?php

class Database{
     public function getConnection() {
          $serverName = "<server name>";
          $connectionInfo = array( "Database"=>"<db|catalog name>");
          $this->conn = null;

          try {
               $this->conn = sqlsrv_connect( $serverName, $connectionInfo);
          }

          catch (Exception $e) {
               echo 'Caught exception: ',  $e->getMessage(), "\n";
               echo "Unable to connect.\n";  
               die( print_r( sqlsrv_errors(), true));  
          }
          
          return $this->conn;
     }
}
