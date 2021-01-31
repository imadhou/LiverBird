<?php

class Model
{
    protected $_table, $_db, $_modelName;
    public $id;
    public function __construct($table)
    {
        $this->_db = DB::getInstance();
        $this->_table = $table;
        $this->_modelName = str_replace(' ','',ucwords(str_replace('_',' ',$table)));
    }

    //retourne un tableau d'objets representant la table dite
    public function get_columns(){
        return $this->_db->get_columns($this->_table);
    }

    public function requete($sql ,$bind = []){
        return $this->_db->requete($sql,$bind);
    }
    public function findFirst($sql,$params = []){
        return $this->_db->findFirst($sql,$params);
    }

    public function insert($fields =[]){
        if (empty($fields)) return false;
        return $this->_db->insert($this->_table, $fields);
    }

    public function update($id = [],$fields = []){
        if (empty($fields) || $id=='') return false;
        return $this->_db->update($this->_table,$id = [],$fields);
    }

    public function delete($id = []){
        if (empty($id) && $this->id == '') return false;
        foreach ($id as $key=>$value){
            $idString = $key;
            $idValue = $value;
        }
        $idValue = ($idValue == '')?$this->id : $idValue;
        return $this->_db->delete($this->_table,$id);
    }

    //cree des attributs pour la classe courante apres une requete select
    protected function populateDataObj($result){
        foreach ($result as $key=>$value){
            $this->$key = $value;
        }
    }

    //a sanitizer apres
    //cree des proprites de l'objet de la classe courante selon les parametres passées (formulaire)
    public function assign($params){
        if (!empty($params)){
            foreach ($params as $key=>$val){
                if (property_exists($this,$key) ){
                    $this->$key = $val;
                }
            }
            return true;
        }
        return false;
    }

    //a riviser pour id
    //insere les donnees d'un objet de la classe courante a la bdd
    public function save(){
        $fields = get_object_vars($this);
        if (property_exists($this,'id')&& $this->id != ''){
            return $this->_db->update('enseignant',['id'=>$this->id],['password'=>$this->password]);
        } else{
            var_dump($this);
                return $this->insert($fields);
        }
    }
}