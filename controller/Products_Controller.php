<?php
require_once "model/Conexion.php";

//$conexion = mysqli_connect('localhost', 'root', '', 'appWeb');

class Products_Controller
{

    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $products = new Products_Controller();
        switch ($option) {
            case 0:
                $result = $products->Consult($array);
                break;
            case 1:
                $result = $products->Insert($array);
                break;
            case 2:
                $result = $products->Update($array);
                break;
            case 3:
                $result = $products->Delete($array);
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        $conexion = Conexion::connection();
        if ($array == null) {
            $sql = "SELECT IdProducto,Nombre,Precio,Cantidad from productos"; 
            return $conexion->query($sql);
        }
        $sql = "SELECT Precio,Cantidad,Nombre,IdProducto from productos WHERE IdProducto='$array'";
        return $conexion->query($sql);
    }
  
    public function Insert($array)
    {
        //conexion
        $conexion = Conexion::connection();
        //consulta
        $sql = "INSERT INTO productos (Nombre,Precio,Cantidad) VALUES (?,?,?)";
        //preparamos la consulta
        $stmt = $conexion->prepare($sql);
        // añadimos los parametros ("tipo de dato s= string, i= entero, d=double",$Variables en su lugar correspondiente con los ?)
        $stmt->bind_param("sid", $array[0], $array[1], $array[2]);
        //ejecutamos el stmt
        $stmt->execute();

        return $conexion->query($sql);
    }

    public function Update($array)
    {

        $conexion = Conexion::connection();
        $sql = "UPDATE productos SET Cantidad=?,Nombre=?,Precio=? WHERE idProducto=?";
        $stmt = $conexion->prepare($sql);
        // añadimos los parametros ("tipo de dato s= string, i= entero, d=double",$Variables en su lugar correspondiente con los ?)
        $stmt->bind_param("isdi", $array[3],$array[1],$array[2], $array[0]);
        //ejecutamos el stmt
        $stmt->execute();


        return $conexion->query($sql);
    }

    public function Delete($array)
    {
        $conexion = Conexion::connection();
        
        $sql = "DELETE FROM productos WHERE IdProducto=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i",$array[0]);
        
        $stmt->execute();

    }
}
