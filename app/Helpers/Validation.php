<?php
class Validation {
    public static function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;
            $fieldRules = explode('|', $ruleSet);
            
            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && empty($value)) {
                    $errors[$field][] = "Field {$field} is required";
                }
                
                if (strpos($rule, 'min:') === 0) {
                    $minLength = intval(substr($rule, 4));
                    if (strlen($value) < $minLength) {
                        $errors[$field][] = "Field {$field} must be at least {$minLength} characters";
                    }
                }
                
                if (strpos($rule, 'max:') === 0) {
                    $maxLength = intval(substr($rule, 4));
                    if (strlen($value) > $maxLength) {
                        $errors[$field][] = "Field {$field} must not exceed {$maxLength} characters";
                    }
                }
                
                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "Field {$field} must be a valid email";
                }
                
                if ($rule === 'date' && !strtotime($value)) {
                    $errors[$field][] = "Field {$field} must be a valid date";
                }
            }
        }
        
        return $errors;
    }
}