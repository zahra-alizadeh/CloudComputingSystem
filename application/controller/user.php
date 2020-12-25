<?php

namespace application\controller;

require_once 'application/model/UserModel.php';
require 'system/vendor/autoload.php';
// generate json web token
include_once 'system/vendor/firebase/php-jwt/src/BeforeValidException.php';
include_once 'system/vendor/firebase/php-jwt/src/ExpiredException.php';
include_once 'system/vendor/firebase/php-jwt/src/SignatureInvalidException.php';
include_once 'system/vendor/firebase/php-jwt/src/JWT.php';

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
        if (empty($_POST['email']) || empty($_POST['password']))
            $this->redirectBack();

        else {
            $userModel = new UserModel();
            $user = $userModel->checkUserExists('email', $_POST['email']);
            if ($user != null) {
                if (password_verify($_POST['password'], $user['password'])) {
                    $this->setSession($user);
                    if ($this->auth($user)) {
                        http_response_code(200);
                        echo json_encode($this->auth($user));
                        $this->redirect('home/home');
                    }
                }
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "login failed!"));
                $this->redirectBack();
            }
        }
    }

//    public function userLogin()
//    {
//        if (empty($_POST['email']) || empty($_POST['password']))
//            $this->redirectBack();
//
//        else {
//            $userModel = new UserModel();
//            $user = $userModel->checkUserExists('email', $_POST['email']);
//            if ($user != null) {
//                if (password_verify($_POST['password'], $user['password'])) {
//                    if ($this->auth()) {
//                        http_response_code(200);
//                        echo json_encode($this->auth());
//                        $this->redirect('home/home');
//                    }
//                } else {
//                    http_response_code(401);
//                    echo json_encode(array("message" => "login failed!"));
//                    $this->redirectBack();
//                }
//            } else
//                $this->redirectBack();
//        }
//    }

    public function auth($user)
    {
        $privateKey = "privateKey";
        $iat = time();
        $exp = $iat + 60 * 60;
        $token = array(
            "iss" => "http://localhost/CloudComputingSystem/application",
            "aud" => "http://localhost/CloudComputingSystemttest/",
            "iat" => $iat,
            "nbf" => $iat + 10,
            "exp" => $exp,
            "data" => array(
                "id" => $user['id'],
                "userName" => $user['user_name'],
                "email" => $user['email']
            ));
        $jwt = JWT::encode($token, $privateKey, 'HS512');
        echo json_encode(array("message" => "successful login!", "jwt" => $jwt, "expireAt" => $exp));
        return array('token' => $jwt, 'expires' => $exp);
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
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeatPassword'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if (strlen($_POST['password'] < 8)) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to register the user."));
            $this->redirectBack();
        } else if ($_POST['password'] != $_POST['repeatPassword'])
            $this->redirectBack();
        else {
            $user = new UserModel();
            $checkUser = $user->checkUser(['email', 'user_name'], [$_POST['email'], $_POST['username']]);

            if ($checkUser == true) {
                http_response_code(400);
                $this->redirectBack();
            } else {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->storeUser($_POST);
                $path = "resource\\" . $_POST['username'] . "_dir";
                mkdir($path);
                http_response_code(200);
                echo json_encode(array("message" => "user registered successfully."));
                $this->redirect('home/home');
            }
        }
    }


//    public function register()
//    {
//        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeatPassword']))
//            $this->redirectBack();
//        else if (strlen($_POST['password'] < 8))
//            $this->redirectBack();
//        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
//            $this->redirectBack();
//        else if ($_POST['password'] != $_POST['repeatPassword'])
//            $this->redirectBack();
//        else {
//            $user = new UserModel();
//            $checkUser = $user->checkUser(['email', 'user_name'], [$_POST['email'], $_POST['username']]);
//
//            if ($checkUser == true)
//                $this->redirectBack();
//            else {
//                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
//
//                $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
//                $token = substr(str_shuffle($data), 0, 8);
//
//                $user->storeUser($_POST, $token);
//                $_SESSION['email'] = $_POST['email'];
//                $path = "resource" . DIRECTORY_SEPARATOR . $_POST['username'] . "_dir";
//                mkdir($path);
//            }
//        }
//    }

    public function volume($userId)
    {
        $maxVolume = 4 * 1024 * 1024 * 1024;
        $totalVolume = 0;
        $userModel = new UserModel();
        $file = $userModel->getVolume($userId);
        foreach ($file as $key => $value) {
            if ($value != null)
                $totalVolume = $totalVolume + $value['content_length'];
        }
        $remindedVolume = ($totalVolume * 100) / $maxVolume;
        if ($remindedVolume < 1)
            $remindedVolume = 1;
        return $remindedVolume;
    }


    public
    function logout()
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