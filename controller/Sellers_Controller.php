<?php
require_once "model/Conexion.php";

class Sellers_Controller
{
    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $seller = new Sellers_Controller();
        switch ($option) {
            case 0:
                $result = $seller->Consult($array);
                break;
            case 1:
                $result = $seller->Insert($array);
                break;
            case 2:
                $result = $seller->Update($array);
                break;
            case 3:
                $result = $seller->Delete($array);
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        $conexion = Conexion::connection();
        if ($array == null) {
            $sql = "SELECT IdUsuario,Nombre1,Apellido1,NDocumento,Celular,Correo,Contrasena,FechaIngreso,Ventas from usuarios WHERE Estado != 0";
            return $conexion->query($sql);
        }
        $sql = "SELECT * from usuarios WHERE IdUsuario='$array'";
        return $conexion->query($sql);

    }

    public function Insert($array)
    {
        $conexion = Conexion::connection();
        date_default_timezone_set('America/Bogota');

        $fecha = date('Y-m-d h:i:s', time());


        $sql = "INSERT INTO usuarios (Nombre1,Apellido1,NDocumento,Celular,Contrasena,Correo,FechaIngreso,IdTUsuario) VALUES (?,?,?,?,?,?,'$fecha',?)";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ssssssi", $array[0], $array[1], $array[2], $array[3], $array[4], $array[5],$array[6]);

        $stmt->execute();
    }
    public function Update($array)
    {
        $conexion = Conexion::connection();
        
        $sql = "UPDATE usuarios SET Nombre1=?,Apellido1=?,NDocumento=?,Celular=?,Contrasena=MD5(?),Correo=? WHERE IdUsuario=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ssssssi",$array[1],$array[2],$array[3],$array[4],$array[5],$array[6],$array[0]);
        
        $stmt->execute();
    }

    public function Delete($array)
    {
        $conexion = Conexion::connection();

        $sql = "UPDATE usuarios SET Estado=0 WHERE IdUsuario=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i", $array[0]);

        $stmt->execute();
    }
}
