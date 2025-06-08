<?php
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new AuthModel();
    }

    public function resetPassword($email, $phone, $new_password)
    {
        $userExists = $this->model->findUserByEmailAndPhone($email, $phone);

        if ($userExists === true) {
            $result = $this->model->updatePassword($email, $new_password);
            return $result === true ? "Password reset successfully." : $result;
        } elseif (is_string($userExists)) {
            return $userExists; // Return error string from model
        } else {
            return "Incorrect email or phone.";
        }
    }
}
