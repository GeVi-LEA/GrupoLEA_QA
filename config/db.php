<?php

class Database
{
    const BD_CAMIONERA = 'MToledoCam';
    const BD_FERRO     = 'MToledo';

    public static function connect()
    {
        $db = new mysqli('localhost', 'root', 'Lea.mx.2020', 'grupo_lea_qa');
        $db->query("set names 'utf8'");

        return $db;
    }

    public static function connectBdBascula($base)
    {
        $nombreServidor = '192.168.1.17';
        $usuario        = 'sa';
        $contrasena     = 'Lea.2018*#';
        $puerto         = 1433;

        try {
            $connectionInfo = "Database = $base; encrypt=false;";
            $db             = new PDO("sqlsrv:server = $nombreServidor; $connectionInfo", $usuario, $contrasena);

            return $db;
        } catch (Exception $e) {
            echo 'Ocurrió un error en la conexión. ' . $e->getMessage();
        }
    }
}