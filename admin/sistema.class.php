<?php
require __DIR__ . '\\config.php';
class Sistema extends Config
{
    var $conn;
    var $count = 0;
    function connect()
    {

        $this->conn = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    }

    function setCount($count)
    {
        $this->count = $count;
    }

    function getCount()
    {
        return $this->count;
    }

    function upload($carpeta)
    {
        if (in_array($_FILES['fotografia']['type'], $this->getImageType())) {
            if ($_FILES['fotografia']['size'] <= $this->getImageSize()) {
                $n = rand(1, 1000000);
                $nombre_archivo = $n . $_FILES['fotografia']['size'] . $_FILES['fotografia']['name'];
                $nombre_archivo = md5($nombre_archivo);
                $extension = pathinfo($_FILES['fotografia']['name'], PATHINFO_EXTENSION);
                $nombre_archivo = $nombre_archivo . "." . $extension;
                $ruta = '..\\uploads\\' . $carpeta . '\\' . $nombre_archivo;
                if (!file_exists($ruta)) {
                    move_uploaded_file($_FILES['fotografia']['tmp_name'], $ruta);
                    return $nombre_archivo;
                }
            }
        }
        return false;
    }
}
