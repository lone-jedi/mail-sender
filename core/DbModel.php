<?php

    class DbModel extends DbInstance
    {
        public function __construct(string $host, string $dbname, string $user, string $pass)
        {
            parent::__construct($host, $dbname, $user, $pass);
        }

        public function dbQuery(string $sql, array $params = []) : PDOStatement
        {
            $db = $this->getConnection();
            $query = $db->prepare($sql);
            $query->execute($params);
            $this->dbCheckError($query);
            return $query;
        }

        private function dbCheckError(PDOStatement $query) : bool
        {
            $errInfo = $query->errorInfo();
            if($errInfo[0] !== PDO::ERR_NONE){
                throw new Exception("DB Error:" . $errInfo[2]);  
            }
            return true;
        }
    }