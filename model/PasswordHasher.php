<?php

class PasswordHasher
{
    public static function hashPassword($password)
    {
        $hashedBytes = hash("sha256", $password, true);

        // Convert the byte array to a hexadecimal string
        $hashedPassword = bin2hex($hashedBytes);

        return $hashedPassword;
    }

    public static function verifyPassword($inputPassword, $hashedPassword)
    {
        // Verify a hashed password against the input password
        $hashedInputPassword = self::hashPassword($inputPassword);
        return strcasecmp($hashedInputPassword, $hashedPassword) === 0;
    }
}

?>
