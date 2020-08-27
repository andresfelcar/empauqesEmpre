<?php
require_once "model/Conexion.php";

class ProductsList_Controller
{
    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $product = new  ProductsList_Controller();
        switch ($option) {
            case 0:
                $result = $product->Consult($array);
                break;
            case 1:
                $result = $product->Insert($array);
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        $conexion = Conexion::connection();

        $sql = "SELECT res.IdProducto, res.Nombre,SUM(res.cantidad) Cantidad from 
        (SELECT pr.Nombre,fa.IdFactura, fa.Fecha,de.IdDFactura,
        de.IdProducto,de.Cantidad from facturas fa
        INNER JOIN detallefacturas de
        INNER JOIN productos pr
        WHERE fa.Fecha = ? AND de.IdProducto = pr.IdProducto
        AND fa.IdFactura = de.IdFactura AND fa.Estado !=0) res
        GROUP by res.IdProducto";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("s", $array);

        $stmt->execute();
        //obtener todos los resultados
        $result = $stmt->get_result();
        //asosiarlos a un array fetch row
        return $result;
    }

    public function Insert($array)
    {
        $conexion = Conexion::connection();
        $sql="SELECT fa.IdUsuario,us.Nombre1,SUM(comision.comisionFinal) com FROM facturas fa 
        INNER JOIN (SELECT de.IdDFactura,de.IdFactura,SUM(de.Cantidad*res.comision) comisionFinal 
        FROM detallefacturas de 
        INNER JOIN (SELECT  IdProducto,CAST(SUM(Precio*Porcentaje) as int) comision 
                    FROM productos 
                    GROUP BY IdProducto) res
        ON de.IdProducto = res.IdProducto 
                    GROUP BY de.IdDFactura) comision 
                    ON fa.IdFactura = comision.IdFactura
                    INNER JOIN usuarios us ON fa.IdUsuario = us.IdUsuario WHERE fa.Fecha BETWEEN ? AND ?";
        
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ss", $array[0],$array[1]);

        $stmt->execute();
        //obtener todos los resultados
        $result = $stmt->get_result();
        //asosiarlos a un array fetch row
        return $result;
    }
}
