<?php


namespace application\controller;

require_once 'application/model/Model.php';
require_once 'application/model/FileModel.php';
session_start();
use application\model\Model;
use application\model\FileModel;

class download extends Controller
{
    public function test()
    {
        echo "__________";
        var_dump($_SERVER['HTTP_RANGE']);
        echo "__________";
        $fileModel = new FileModel();
        $file = $fileModel->findOne('14', '11');
        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $content = file_get_contents($path);
        $fileDetail = array('name' => $file['name'], 'body' => $content);
        $jsonResponse = json_encode($fileDetail);
        var_dump($jsonResponse);
    }

    public function files()
    {
        $fileModel = new FileModel();
        $files = $fileModel->findAll($_SESSION['userId']);
        if ($files != null) {
            $jsonResponse = json_encode($files);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($files);
            http_response_code(200);
        } else {
            http_response_code(404);
            $jsonResponse = json_encode(array('message' => 'No File Is Found!'));
        }

        echo $jsonResponse;
    }

//    public function file($id)
//    {
//        $fileModel = new FileModel();
//        $file = $fileModel->findOne('5', '1');
////        $jsonResponse = array('id' => $file['id'], 'name' => $file['name'], 'body' => file_get_contents($file['path']));
////        $file = $fileModel->findOne($id, $_SESSION['userId']);
//
//        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
////        $content = file_get_contents($path);
////        $fileDetail = array('name' => $file['name'], 'body' => $content);
////        $jsonResponse = json_encode($fileDetail);
////        var_dump($jsonResponse);
//        if (file_exists($path)) {
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header("Accept-Ranges: bytes");
//            $size = filesize($path);
//            $begin = 0;
//            $end = $size;
//            if (isset($_SERVER['HTTP_RANGE'])) {
//                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
//                    $range = $_SERVER['HTTP_RANGE'];
//                    $begin = intval($matches[0]);
//                    if (!empty($matches[1]))
//                        $end = intval($matches[1]);
//                }
//            }
//            header('Content-Length: ' . filesize("together.png"));
//
//            if ($begin < 0 || $end > $size)
//                header('HTTP/1.1 416 Requested Range Not Satisfiable');
//            else
//                header('HTTP/1.0 200 OK');
//            header('Content-Disposition: attachment; filename="' . basename($file['name']) . '"');
//            echo json_encode($file);
//            set_time_limit(0);
//            $fileRead = @fopen($path, "rb");
//            while (!feof($fileRead)) {
//                print @fread($fileRead, 1024 * 8);
//                ob_flush();
//                flush(); // Flush system output buffer
//            }
//            die();
//        } else {
//            http_response_code(404);
//            die();
//        }
//    }
    public function file($id)
    {
        $fileModel = new FileModel();
        $file = $fileModel->findOne($id[2], $_SESSION['userId']);

        $path = realpath(dirname(__FILE__) . "/../../" . $file['path']);
        $fileSize = filesize($path);

        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $fileSize);

            $begin = 0;
            $end = $fileSize;
            if (isset($_SERVER['HTTP_RANGE'])) {
                echo "helll";
                var_dump($_SERVER);
                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
                    $range = $_SERVER['HTTP_RANGE'];
                    $begin = intval($matches[0]);
                    if (!empty($matches[1]))
                        $end = intval($matches[1]);
                }
            }

            if ($begin < 0 || $end > $fileSize)
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
            else
                header('HTTP/1.0 200 OK');

            http_response_code(200);
            set_time_limit(0);
            $fileRead = @fopen($path, "rb");
            while (!feof($fileRead)) {
                if ($fileSize < 1024 * 8)
                    print @fread($fileRead, $fileSize);
                else
                    print @fread($fileRead, 1024 * 8);
                ob_flush();
                flush(); // Flush system output buffer
            }
            die();
        } else {
            http_response_code(404);
            die();
        }
    }

}