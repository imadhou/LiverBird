<?php
class Modules extends Model{
    public $id, $nom, $description, $image, $niveau;
    public function __construct($id = '')
    {
        $table = 'module';
        parent::__construct($table);

        if ($id != ''){
            $mod = $this->_db->findFirst("select * from {$table} where id = ?",[$id]);
            $this->populateDataObj($mod);
        }
    }

    public function findByid($id){
        $this->_db->findFirst("select * from modules where id = ?",[$id]);
    }
}