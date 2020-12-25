<?php


namespace application\controller;

session_start();
require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';
include('user.php');

use application\model\Model;
use application\model\FileModel;

class home extends Controller
{
    public function home()
    {
        $fileModel = new FileModel();
        $files = $fileModel->findAll($_SESSION['userId']);
        $user = new user();
        $volume = $user->volume($_SESSION['userId']);

        return $this->view('home1', compact('files', 'volume'));
    }

//    public function viewFile($fileId)
//    {
//        var_dump($fileId);
//        $fileModel = new FileModel();
//        $file = $fileModel->findOne($fileId[2], $_SESSION['userId']);
//
//        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
//        $fileSize = filesize($path);
//
//        if (file_exists($path)) {
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
////            header('Content-Length: ' . $fileSize);
//
//            $begin = 0;
//            $end = $fileSize;
//            if ($_SERVER['Content-Type'] == 'application/text' or $_SERVER['Content-Type'] == 'application/pdf') {
//                if ($fileSize / 1024 < 1024)
//                    $x = $end - 200;
//                else
//                    $x = $end - ($end / 3);
//
//                header("Content-Range: bytes 0-$x");
//            }
//
//            if (isset($_SERVER['HTTP_RANGE'])) {
//                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
//                    $range = $_SERVER['HTTP_RANGE'];
//                    $begin = intval($matches[0]);
//                    if (!empty($matches[1]))
//                        $end = intval($matches[1]);
//                }
//            }
//
//            if ($begin < 0 || $end > $fileSize)
//                header('HTTP/1.1 416 Requested Range Not Satisfiable');
//            else
//                header('HTTP/1.0 200 OK');
//
//            http_response_code(200);
//            set_time_limit(0);
//            $fileRead = @fopen($path, "rb");
//            while (!feof($fileRead)) {
//                if ($fileSize < 1024 * 8)
//                    print @fread($fileRead, $fileSize);
//                else
//                    print @fread($fileRead, 1024 * 8);
//                ob_flush();
//                flush(); // Flush system output buffer
//            }
//            die();
//        } else {
//            http_response_code(404);
//            die();
//        }
//    }
    public function viewFile($fileId)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($fileId[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $filename = basename($path);

// Header content type
        header('Content-type: application/octet-stream');

//        header('Content-Disposition: inline; filename="' . $filename . '"');
        header("Content-Disposition: inline; filename=$filename");

        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($path));

        http_response_code(200);

//        header('Accept-Ranges: bytes 0-100');

//        if (isset($_SERVER['HTTP_RANGE'])) {
//            if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
//                $range = $_SERVER['HTTP_RANGE'];
//                $begin = intval($matches[0]);
//                if (!empty($matches[1]))
//                    $end = intval($matches[1]);
//            }
//        }
//
//        if ($begin < 0 || $end > filesize($path))
//            header('HTTP/1.1 416 Requested Range Not Satisfiable');
//        else
//            header('HTTP/1.0 200 OK');
// Read the file
        @readfile($filename);
//        $this->redirectBack();
    }
}