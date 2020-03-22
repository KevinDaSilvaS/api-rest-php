<?php

final class Validations{

    public function validateString(string $message)
    {
        return strlen($message) <= 45 && !is_numeric($message);
    }

    public function validateMail(string $email)
    {
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    public function validateInteger(string $integer)
    {
        return filter_var($integer,FILTER_VALIDATE_INT) && $integer > 0;
    }
}

?>