<?php

function check_login($conn){
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $query = "select * from users where username = '$username' limit 1";

        $result = mysqli_query($conn,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            echo ("da");
            return $user_data;
        }
    }
    echo ("ne");
    die;
}

 function uidExists($conn, $name){
    $sql = "SELECT * FROM users WHERE name=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo ("error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close();
}

function loginUser($conn, $name, $pass){
    $uidExists = uidExists($conn, $name);

    if($uidExists === false){
        echo("wrong login");
        exit();
    }

    $pwdHashed = $uidExists["password"];
    $checkPwd = password_verify($pass, $pwdHashed);

    if($checkPwd === false){
        echo("wrong login");
        exit();
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["name"] = $uidExists["name"];
        header("location: igra.html");
        exit();
    }
}

?>

