<?php
class Clients_Controller{
    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $login = new Clients_Controller();
        switch ($option) {
            case 0:
                $result = $login->Consult($array);
                break;
            case 1:
                $result = $login->Insert($array);
                break;
            case 2:
                $result = $login->Update($array);
                break;
            case 3:
                $result = $login->Delete($array);
                break;
            case 4:
                $result = $login->View($array);
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        if($array==null){  
            $conexion = Conexion::connection();
            $sql = "SELECT IdCliente,Nombre1,Id,Celular,Correo,Direccion from clientes WHERE Estado !=0";
            return $conexion->query($sql);
        }
        $conexion = Conexion::connection();
            $sql = "SELECT IdCliente,Nombre1,Id,Celular,Correo,Direccion from clientes WHERE IdCliente='$array'";
            return $conexion->query($sql);
       }

    public function Insert($array)
    {
        $conexion = Conexion::connection();
        
        $sql = "INSERT INTO clientes (Nombre1,Id,Celular,Direccion) VALUES (?,?,?,?)";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ssss", $array[0],$array[1],$array[2],$array[3]);
        
        $stmt->execute();
    }
    
    public function Update($array)
    {
        $conexion = Conexion::connection();
        
        $sql = "UPDATE clientes SET Nombre1=?,Id=?,Celular=?,Correo=?,Direccion=? WHERE IdCliente=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("sssssi",$array[1],$array[2],$array[3],$array[4],$array[5],$array[0]);
        
        $stmt->execute();
    }

    public function Delete($array)
    {
        $conexion = Conexion::connection();
        
        $sql = "UPDATE clientes SET Estado =0 WHERE idCliente=? ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("i",$array[0]);
        
        $stmt->execute();

    }
    public function View($array)
    {

        $conexion = Conexion::connection();
        $sql = "SELECT IdCliente,Nombre1,Id,Celular,Correo,Direccion from clientes WHERE IdZona='$array'";
        
        return $conexion->query($sql);
       
    }
}
?>