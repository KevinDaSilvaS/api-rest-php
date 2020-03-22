<?php
require_once ('HandlerDataBase.php');
require_once ('Validations.php');

$validate = new Validations();
$db = new HandlerDataBase();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!$data) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Expected parameters but null given"));
            exit;
        }

        $errors =  array();
        if (!isset($data->first_name) || !$validate->validateString($data->first_name)) {
            array_push($errors,"Incorrect user name informed");
        }

        if (isset($data->last_name) && !$validate->validateString($data->last_name)  ) {
            array_push($errors,"Incorrect last name informed");
        }

        if (!isset($data->email) || !$validate->validateMail($data->email)) {
            array_push($errors,"Incorrect email informed");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Invalid or null fields",
            "errors"=>$errors));
            exit;
        }

        $firstName = $data->first_name;
        isset($data->last_name) ? $lastName = $data->last_name : $lastName = '';
        $email = $data->email;
        $insertNewUser = $db->insertFields("users",
        "name,last_name,email","'$firstName','$lastName','$email'");

        if ($insertNewUser != 1) {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(array("response"=>"Unexpected exception happened.\n " . $insertNewUser));
            exit;
        }

        header("HTTP/1.1 201 CREATED");
        echo json_encode(array("response"=>"New user successfully created."));
        break;

    case 'GET':
        header("HTTP/1.1 200 OK");
        $searchUsers = $db->selectFields("*","users");
        echo json_encode($searchUsers);
        break;

    case 'PUT':
        $userId = filter_input(INPUT_GET,"id");
        if (!$userId) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"User id cannot be null"));
            exit;
        }
        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Expected parameters but null given"));
            exit;
        }

        $errors =  array();
        if (isset($data->first_name) && !$validate->validateString($data->first_name)) {
            array_push($errors,"Incorrect user name informed");
        }

        if (isset($data->last_name) && !$validate->validateString($data->last_name)  ) {
            array_push($errors,"Incorrect last name informed");
        }

        if (isset($data->email) && !$validate->validateMail($data->email)) {
            array_push($errors,"Incorrect email informed");
        }

        if (isset($userId) && !$validate->validateInteger($userId)) {
            array_push($errors,"Incorrect id informed");
        }

        if (count($errors) > 0) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Invalid or null fields",
            "errors"=>$errors));
            exit;
        }

        isset($data->first_name) ? $firstName = "name = '$data->first_name'" : $firstName = '';
        isset($data->last_name) ? $lastName = ",last_name = '$data->last_name'" : $lastName = '';
        isset($data->email) ? $email = ",email = '$data->email'" : $email = '';

        $updateUser = $db->update("users",$firstName . $lastName.$email,"id_users = '$userId'");

        if ($updateUser != 1) {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(array("response"=>"Unexpected exception happened.\n " . $updateUser));
            exit;
        }

        header("HTTP/1.1 201 CREATED");
        echo json_encode(array("response"=>"User successfully updated."));

        break;

    case 'DELETE':
        $userId = filter_input(INPUT_GET,"id");
        if (!$userId) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"User id cannot be null"));
            exit;
        }

        if (isset($userId) && !$validate->validateInteger($userId)) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(array("response"=>"Incorrect id informed"));
            exit;
        }

        $delete = $db->delete("users","id_users = '$userId'");

        if ($delete != 1) {
            header("HTTP/1.1 500 INTERNAL SERVER ERROR");
            echo json_encode(array("response"=>"Unexpected exception happened.\n " . $updateUser));
            exit;
        }

        header("HTTP/1.1 201 CREATED");
        echo json_encode(array("response"=>"User successfully deleted."));

        break;
    
    default:
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode(array("response"=>"Requisition type not expected"));
        break;
}

?>