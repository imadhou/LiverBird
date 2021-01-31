<?php
/**
 * Created by PhpStorm.
 * User: imadhou
 * Date: 7/19/20
 * Time: 8:19 AM
 */

class Validation
{
    public $_errors = [];
    private $_passed = false, $_db = null;
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source,$items=[]){
        $this->_errors = [];
        foreach ($items as $item=>$rules){
            $item = htmlentities($item);
            $display = $rules['display'];
            foreach ($rules as $rule=>$rule_value){
                $value = htmlentities(trim($source[$item]));

                if ($rule ==='required' && empty($value)){
                    $this->addError(["{$display} est requis ",$item]);
                }elseif (!empty($value)){
                    switch ($rule){
                        case 'matches':
                            if ($value != $source[$rule_value]){
                                $matchDisplay = $items[$rule_value]['display'];
                                $this->addError(["{$matchDisplay} et {$display} doivent être identiques",$item]);
                            }
                            break;
                        case 'unique':
                            $check=$this->_db->requete("select * from {$rule_value} where {$item} = ?",[$value]);
                            if ($check->count()){
                                $this->addError(["Cet {$display} est déja utlisé! ",$item]);
                            }
                            break;
                        case 'unique_update':
                            $t = explode(',',$rule_value);
                            $table = $t[0];
                            $id = $t[1];
                            $query = $this->_db->requete("select * from {$table} where id != ? and {$item} = ?",[$id,$value]);
                            if ($query->count()){
                                $this->addError(["Cet {$display} déja existant! ",$item]);
                            }
                            break;
                        case 'is_numeric':
                            if (!is_numeric($value)){
                                $this->addError(["{$display} doit etre un numero valide",$item]);
                            }
                            break;
                        case 'valid_email':
                            if (!filter_var($value,FILTER_VALIDATE_EMAIL)){
                                $this->addError(["{$display} doit etre un email valide. ",$item]);
                            }
                            break;
                        case 'min':
                            if (strlen($value)<$rule_value){
                                $this->addError(["{$display} doit contenir au minimum {$rule_value} caracteres",$item]);
                            }
                            break;
                        case 'admin':
                            if ($value != ADMIN){
                                $this->addError(["{$display} n'existe pas",$item]);
                            }
                            break;
                        case 'adminpasswd':
                            if (!password_verify($value,PASSWORD)){
                                $this->addError(["{$display} érroné, vuillez introduire un mot de passe valide",$item]);
                            }
                            break;
                        case 'password' :
                            if (!preg_match('/[a-zA-Z]/',$value) || !preg_match('/\d/',$value) || !preg_match('/[^a-zA-Z\d]/',$value)){
                                $this->addError(["{$display} doit contenir au moins un chiffre une lettre miniscule une majuscule et un charactere bizzare!",$item]);
                            }
                    }
                }
            }
        }

        if (empty($this->_errors)){
            $this->_passed = true;
        }
        return $this;
    }

    public function passed(){
        return $this->_passed;
    }

    public function error(){
        return $this->_errors;
    }

    public function displayErrors(){
        $html = '<ul>';
        foreach ($this->_errors as $error){
            if (is_array($error)){
                $html.='<li class="text-danger"><p>'.$error[0].'</p></li>';
                $html.='<script>jQuery("document").ready(function(){jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error");});</script>';
            }else{
                $html.='<li class="text-danger"<p>'.$error.'</p></li>';
                $html.='<script>jQuery("document").ready(function(){jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error");});</script>';
            }
        }
        $html.='</ul>';
        return $html;
    }

    public function addError($error){
        $this->_errors[] = $error;
        if (empty($this->_errors)){
            $this->_passed = true;
        }else{
            $this->_passed = false;
        }
    }
    public function errors(){
        return $this->_errors;
    }

}