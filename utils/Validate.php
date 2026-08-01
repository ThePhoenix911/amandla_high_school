<?php

class Validate{

    public static function validateTextField(String $field_name, String $field_value, String $message_name,
                                             int $min_length, int $max_length, array $specials): array {
        if(FieldRequirements::isFieldEmpty($field_value)) {
            return ['error_message' => "$message_name is required", 'field_name' => "$field_name"];
        }

        if(FieldRequirements::isFieldLengthLessThan($field_value, $min_length)) {
            return ['error_message' => "$message_name is too short", 'field_name' => "$field_name"];
        }

        if(FieldRequirements::isFieldLengthGreaterThan($field_value, $max_length)) {
            return ['error_message' => "$message_name is too long", 'field_name' => "$field_name"];
        }

        if(!empty($specials)) {
            if(isset($specials['digit'])) {
                if(!FieldRequirements::isDigits($field_value)) {
                    return ['error_message' => "$message_name must be digits only", 'field_name' => "$field_name"];
                }
            }


            if(isset($specials['id_number'])) {
                if(!FieldRequirements::isRSAIDNum($field_value)) {
                    return ['error_message' => "$message_name is invalid", 'field_name' => "$field_name"];
                }
            }

            if(isset($specials['phone_number'])) {
                if(!FieldRequirements::isValidPhone($field_value)) {
                    return ['error_message' => "$message_name is invalid", 'field_name' => "$field_name"];
                }
            }

            if(isset($specials['password'])) {
                if(FieldRequirements::isPasswordWeak($field_value)) {
                    return ['error_message' => "Password must have one special character, letter, and a number", 'field_name' => "$field_name"];
                }
            }

        }

        return ['error_message' => '', 'field_name' => "$field_name"];
    }

    public static function validateEmailField(String $field_name, String $field_value): array {
        if(FieldRequirements::isFieldEmpty($field_value)) {
            return ['error_message' => 'Email is required', 'field_name' => "$field_name"];
        }

        if(!FieldRequirements::isEmailValid($field_value)) {
            return ['error_message' => 'Email is invalid', 'field_name' => "$field_name"];
        }

        if(FieldRequirements::isFieldLengthGreaterThan($field_value, 255)) {
            return ['error_message' => 'Email is too long', 'field_name' => "$field_name"];
        }

        return ['error_message' => '', 'field_name' => "$field_name"];
    }
}