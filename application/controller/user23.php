<?php

namespace application\controller;

require_once 'application/model/UserModel.php';
require 'system/vendor/autoload.php';

use application\model\UserModel;
use \Firebase\JWT\JWT;

class user extends Controller
{
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    public function login()
    {
        return $this->view('login');
    }

    public function userLogin()
    {
        var_dump($_SERVER);

        if (empty($_POST['email']) || empty($_POST['password']))
            $this->redirectBack();
//        else if (empty($_SERVER['PHP_AUTH_USER'])) {
//            header("WWW-Authenticate: Basic realm=\"private area\"");
//            header("HTTP\ 1.0 401 Unauthorized");
//            echo "There is an error";
//            $this->redirectBack();
//        }
        else {
            $userModel = new UserModel();
            $user = $userModel->checkUserExists('email', $_POST['email']);
            if ($user != null) {
                var_dump($user);
                if ($_SERVER['PHP_AUTH_USER'] == $user['user_name']) {
                    $this->setSession($user);
                    $this->redirect('home/home');
                } else
                    $this->redirectBack();
            } else
                $this->redirectBack();
        }
    }

    public function setSession($user)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userName'] = $user['user_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['message'] = "you are logged in!";
        $_SESSION['logIn_time'] = time();
        setcookie($_SESSION['userName'], 'imdb', time() + 3600);
    }

    public function registration()
    {
        return $this->view('register');
    }

    public function register()
    {
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeatPassword']))
            $this->redirectBack();
        else if (strlen($_POST['password'] < 8))
            $this->redirectBack();
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $this->redirectBack();
        else if ($_POST['password'] != $_POST['repeatPassword'])
            $this->redirectBack();
        else {
            $user = new UserModel();
            $checkUser = $user->checkUser(['email', 'user_name'], [$_POST['email'], $_POST['username']]);

            if ($checkUser == true)
                $this->redirectBack();
            else {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                $token = substr(str_shuffle($data), 0, 8);

                $user->storeUser($_POST, $token);
                $_SESSION['email'] = $_POST['email'];
                $path = "resource" . DIRECTORY_SEPARATOR . $_POST['username'] . "_dir";
                mkdir($path);
            }
        }
    }

    public function volume()
    {
        $v = 0;
        $userModel = new UserModel();
        $file = $userModel->getVolume(2);
        foreach ($file as $key => $value) {
            if ($value != null)
                $v = $v + $value['content_length'];
        }
        $remindedv = $v / (1024 * 1024);
        var_dump($remindedv);
//        $file = $userModel->getVolume($_SESSION['userName']);
    }

//     public function enterPassword()
//    {
//        $userModel = new UserModel();
//        $user = $userModel->checkUserExists('email', $_SESSION['email']);
//        if ($_POST['authentication'] == $user['token']) {
//            $userModel = new UserModel();
//            $userModel->updateUser($user['id'], ['status'], ['verified']);
//            $this->setSession($user);
//            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
//            header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . BASE_DIR . 'Home/home');
//        } else
//            $this->redirectBack();
//
//    }
//
//    public function forgetPassword()
//    {
//        return $this->view('forgot-password');
//    }
//
//    public function forgetUserPassword()
//    {
//        if (empty($_POST['email']))
//            $this->redirectBack();
//        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
//            $this->redirectBack();
//        else {
//            $user = new UserModel();
//            $checkUser = $user->checkUserExists('email', $_POST['email']);
//
//            if ($checkUser != null)
//                $this->redirectBack();
//            else {
//                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
//                $password = substr(str_shuffle($data), 0, 8);
//
//                $message = '<h3 style="direction: rtl">سلام</h3></br>
//                             <h4 style="direction: rtl">رمز شما تغییر یافت :</h4></br>' . $password;
//
//                $this->sendEmail($_POST, $message);
//            }
//        }
//    }
//
//    public function changePassword()
//    {
//        return $this->view('change-password');
//    }
//
//    public function changeUserPassword()
//    {
//        if (empty($_POST['currentPassword']) || empty($_POST['newPassword']) || empty($_POST['repeatNewPassword']))
//            $this->redirectBack();
//        else if (strlen($_POST['newPassword'] <= 8))
//            $this->redirectBack();
//        else if ($_POST['newPassword'] != $_POST['repeatNewPassword'])
//            $this->redirectBack();
//        else {
//            $user = new UserModel();
//            $checkUser = $user->checkUserExists('id', $_SESSION['userId']);
//
//            if ($checkUser == null)
//                $this->redirectBack();
//            else {
//                $_POST['newPassword'] = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
//                $user->updateUser($_SESSION['userId'], ['password'], [$_POST['newPassword']]);
////                $user->updatePassword($_SESSION['userId'], $_POST['newPassword']);
//                $this->redirectBack();
//            }
//        }
//    }

    public function logout()
    {
        if (isset($_SESSION['userId'])) {
            setcookie($_SESSION['userName'], '', time() - 3600);
            unset($_SESSION['userId']);
            unset($_SESSION['email']);
            unset($_SESSION['userName']);
            unset($_SESSION['loggedIn']);
            unset($_SESSION['message']);

            session_destroy();
        }
        $this->redirect('Home/home');
    }
}