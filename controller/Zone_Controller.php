<?php
require_once "model/Conexion.php";

class Zone_Controller
{
    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $zone = new Zone_Controller();
        switch ($option) {
            case 0:
                $result = $zone->Consult($array);
                break;
            case 1:
                $result = $zone->Insert($array);
                break;
            case 2:
                $result = $zone->Update($array);
                break;
            case 3:
                $result = $zone->Delete($array);
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        $conexion = Conexion::connection();
        if ($array == null) {
            $sql = "SELECT * from zonas WHERE Estado !=0";
            return $conexion->query($sql);
        }

        $sql = "SELECT * from zonas WHERE IdZona='$array'";
        return $conexion->query($sql);
    }

    public function Insert($array)
    {
        $conexion = Conexion::connection();

        $sql = "INSERT INTO zonas (NombreZona) VALUES (?)";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("s", $array);

        $stmt->execute();
    }

    public function Update($array)
    {
        $conexion = Conexion::connection();

        $sql = "UPDATE zonas SET NombreZona=? WHERE IdZona=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("si", $array[1], $array[0]);

        $stmt->execute();
    }

    public function Delete($array)
    {
        $conexion = Conexion::connection();

        $sql = "UPDATE zonas SET Estado=0 WHERE IdZona=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i", $array);

        $stmt->execute();
    }
}
