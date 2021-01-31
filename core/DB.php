<?php


class DB
{
    private static $instance = null;
    private $_pdo, $_error, $_result,$_query, $_count;
    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWD);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        }catch (PDOException $exception){
            die($exception->getMessage());
        }
    }

    public static function getInstance(){
        if (!isset($instace)){
            self::$instance = new DB;
        }
        return self::$instance;
    }

    public function requete($sql,$bind = []){
        $this->_error = false;
        $this->_query = $this->_pdo->prepare($sql);
        if ($this->_query){
            $x = 1;
            if (count($bind)){
                foreach ($bind as $b){
                    $this->_query->bindValue($x,$b);
                    $x++;
                }
            }
            if ($this->_query->execute()){
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
            $this->_error = true;
            }
        }
        return $this;
    }
    public function findFirst($sq, $params = []){
        if ($this->requete($sq,$params)){
            return $this->first();
        }
        return false;
    }

    public function first(){
        return (!empty($this->_result)) ? $this->_result[0] : [];
    }

    public function insert($table, $fields=[]){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach ($fields as $field => $value){
            if ($field !='_db' && $field !='_table' && $field != '_modelName' && $field != 'id'){
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
            }
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
        if(!$this->requete($sql, $values)->error()){
            return true;
        }
        return false;

    }
    public function update($table,$id = [],$fields = []){
        $fieldString='';
        $values = [];
        foreach ($fields as $field=>$value){
            $fieldString .= ' '.$field.' =?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString,',');
        foreach ($id as $key=>$value){
            $idString = $key;
            $idValue = $value;
        }
        $sql = "update {$table} set {$fieldString} where {$idString} = {$idValue}";
        if (!$this->requete($sql,$values)->error()){
            return true;
        }
        return false;
    }

    public function delete($table, $id){
        $sql = "delete from {$table} where id = {$id}";
        if (!$this->requete($sql)->error()){
            return true;
        }
        return false;
    }

    public function result(){
        return $this->_result;
    }

    public function count(){
        return $this->_count;
    }

    public function error(){
        return $this->_error;
    }

    public function get_columns($table){
        return $this->query("show columns from {$table}")->result();
    }



}