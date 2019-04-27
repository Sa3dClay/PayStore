<?php
session_start();

include_once './DataBase.php';
include_once '../Controllers/UserFactory.php';
$file_name = './credential.php';

$db = DataBase::getInstance($file_name);
$conn = $db->get_connection();

$email = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'email'));
$pass  = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'pass' ));

$admin = UserFactory::build('Admin');

if($email == $admin->email) {
    $check = $admin->log_in($pass);
    if ($check) {
        $_SESSION['admin_id'] = $admin->id;
        echo "<SCRIPT> alert('welcome: Admin'); </SCRIPT>";
        echo "<script> window.location.assign('../Views/index.php'); </script>";
    } else {
        echo "<SCRIPT> alert('Wrong email or password');</SCRIPT>";
        echo "<script> window.location.assign('../Views/login.php'); </script>";
    }
} else {

    $my_query = "SELECT email FROM customer";
    $result = mysqli_query($conn, $my_query);

    if(!$result) {
        die("error in query");

    } else {
        $bool = false;

        while($row = mysqli_fetch_assoc($result)) {
            if($email == $row['email']) {
                $bool = true;
                break;
            }
        }

        if($bool) {
            $my_query2 = "SELECT password FROM customer WHERE email = '$email'";
            $result2 = mysqli_query($conn, $my_query2);

            if(!$result2) {
                die("Error in query");
            } else {
                $row2 = mysqli_fetch_assoc($result2);
                $cu = UserFactory::build('Customer');
                if($pass != $row2['password']) {
                    echo "<SCRIPT> alert('Wrong email or password');</SCRIPT>";
                    echo "<script> window.location.assign('../Views/login.php'); </script>";
                } else {
                    $my_query3 = "SELECT id, name FROM customer where email = '$email'";
                    $result3 = mysqli_query($conn, $my_query3);
                    $row3 = mysqli_fetch_assoc($result3);

                    $id = $row3['id'];
                    $name = $row3['name'];
                    $_SESSION['s_id'] = $id;
                    $_SESSION['s_name'] = $name;

                    if(isset($_SESSION['s_id'])) {
                        echo "<SCRIPT> alert('welcome: $name,'); </SCRIPT>";
                        echo "<script> window.location.assign('../Views/index.php'); </script>";
                    }
                }
            }

        } else {

            echo "<SCRIPT> alert('Wrong email or password'); </SCRIPT>";
            echo "<script> window.location.assign('../Views/login.php'); </script>";
        }
    }
}
