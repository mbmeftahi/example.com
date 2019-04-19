<?php

namespace About\Validation;

class Validate{

    public $validation = [];

    public $errors = [];

    private $data = [];

    public function notEmpty($value){

        if(!empty($value)){
            return true;
        }
    

        return false;

    }

    public function email($value){

        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }

        return false;

    }

    /**
     * Check and retund strong if the passowrd has the lenght, 
     * also chack if numbers, letters and special
     * charactors exist.
     */
    public function strength($value) {
        $strong=0;
        if (strlen($value) >= 8) {
            $strong++;
        }
        if (preg_match("([\W]{1,})", $value)) {
            $strong++;
        }
        if (preg_match("([0-9]{1,})", $value)) {
            $strong++;
        }
        if (preg_match("([a-z]{1,})", $value)) {
            $strong++;
        }
        if (preg_match("([A_Z]{1,})", $value)) {
            $strong++;
        }
        return $strong===5?true:false;
    }

    function matchPassword($value){
        if($this->data['password'] === $value){
            return true;
        }
        return false;
    }


    public function check($data){

        $this->data = $data;

        foreach(array_keys($this->validation) as $fieldName){

            $this->rules($fieldName);
        }

    }

    public function rules($field){
        foreach($this->validation[$field] as $rule){
            if($this->{$rule['rule']}($this->data[$field]) === false){
                $this->errors[$field] = $rule;
            }
        }
    }

    /**
     * Detects and returns an error message for a given field
     * @param  string $field
     * @return mixed
     */
    public function error($field){
        if(!empty($this->errors[$field])){
            return $this->errors[$field]['message'];
        }

        return false;
    }

    /**
     * Returns the user submitted value for a give key
     * @param  string $key
     * @return string
     */
    public function userInput($key){
        return (!empty($this->data[$key])?$this->data[$key]:null);
    }

}

