<?php
 
$db_connect = mysqli_connect("localhost","root","","restapi");
$response = array();
 
header('Content-Type: application/json');
 
if(mysqli_connect_errno()){
    $response["error"] = TRUE;
    $response["message"] = "Gagal Bro!";
    echo json_encode($response);
    exit;
}
 
if(isset($_POST["type"]) && ($_POST["type"]=="signup") && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]))
{
 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
 
    $checkEmailQuery = "select * from users where email = '$email'";
    $result = mysqli_query($db_connect,$checkEmailQuery);
 
    if($result->num_rows>0){
        $response["error"] = TRUE;
        $response["message"] = "Email udah ada yang pake!!!!";
        echo json_encode($response);
    exit;
    }else{
        $signupQuery = "INSERT INTO users(name, email, password) values('$name','$email','$password')";
        $signupResult = mysqli_query($db_connect,$signupQuery);
 
        if($signupResult){
            $id = mysqli_insert_id($db_connect);
            $userQuery = "SELECT id,name,email FROM users WHERE id = ".$id;
            $userResult = mysqli_query($db_connect,$userQuery);
 
            $user = mysqli_fetch_assoc($userResult);
 
            $response["error"] = TRUE;
            $response["message"] = "Berhasil Daftar!";
            echo json_encode($response);
            exit;
        }else{
            $response["error"] = TRUE;
            $response["message"] = "Gagal Daftar!";
            echo json_encode($response);
            exit;
        }
    }
}else if(isset($_POST["type"]) && ($_POST["type"]=="login") && isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = ($_POST["password"]);
 
    $userQuery = "select id,name,email from users where email = '$email' && password = '$password'";
    $result = mysqli_query($db_connect,$userQuery);
 
    if($result->num_rows==0){
        $response["error"] = TRUE;
        $response["message"] = "User Gada bos!";
        echo json_encode($response);
        exit;
    } else {
        $user = mysqli_fetch_assoc($result);
        $response["error"] = TRUE;
        $response["message"] = "Berhasil Login!";
        echo json_encode($response);
        exit;
    }
} else {
        $response["error"] = TRUE;
        $response["message"] = "Parameter salah!";
        echo json_encode($response);
}
 
?>