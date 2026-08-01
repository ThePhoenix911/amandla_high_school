<?php

class  FieldRequirements {


    public static function isFieldEmpty($field): bool
    {
        if(empty($field)) {
            return true;
        }else {
            return false;
        }
    }

    public static function isFieldEqualTo($field, $val):bool {
        if(strlen($field) == $val) {
            return true;
        }else {
            return false;
        }
    }

    public static function isFieldLengthLessThan($field, $min): bool {
        if(strlen($field) < $min) {
            return true;
        }else{
            return false;
        }
    }

    public static function isFieldLengthGreaterThan($field, $max): bool {
        if(strlen($field) >= $max) {
            return true;
        }else {
            return false;
        }
    }


    public static function isFieldMatch($field1, $field2): Bool{
        if($field1 != $field2) {
            return false;
        }else{
            return true;
        }
    }

    public static function isEmailValid($email): bool {
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);

        if($result) {
            return true;
        }else{
            return false;
        }
    }


    public static function isValidPhone($phone): bool {
        //checks if the phone number starts with zero and the has 9 remaining digits
        // The '^' specifies the beginning of the string and '$' specifies the end
        //i.e the string must begin with a zero and end with 9 character digits
        $pattern = '/^0\d{9}$/';
        $result = preg_match($pattern, $phone);

        if(!$result) {
            return false;
        }else {
            return true;
        }
    }

    public static function isDigits($digits): bool {
        // Matches any argument with characters with the minimum character length of 1
        $pattern = '/^\d{1,}$/';
        $result = preg_match($pattern, $digits);

        if(!$result) {
            return false;
        }else {
            return true;
        }
    }

    public static function isPasswordWeak($password): bool {
        $pattern = '/^(?=.*[[:digit:]])(?=.*[[:word:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
        if(preg_match($pattern, $password) == 0) {
            //pattern does not match - therefore, password is weak
            return true;
        }else{
            //pattern matches - password is strong
            return false;
        }
    }

    public static function isRSAIDNum($field_value): bool {
        $pattern = '/^[[:digit:]]{2}(0?[1-9]|1[0-2])(0?[1-9]|[12][[:digit:]]|3[01])[[:digit:]]{4}[0-1][[:digit:]]{2}$/';
        if(preg_match($pattern, $field_value) == 1) {
            return true;
        }else {
            return false;
        }
    }

}
?>