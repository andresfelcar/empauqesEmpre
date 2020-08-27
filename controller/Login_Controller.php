<?php
require_once "model/Conexion.php";

class Login_Controller
{
    private function __construct()
    {
    }

    public static function Main($option, $array = [])
    {
        $login = new Login_Controller();
        switch ($option) {
            case 0:
                $result = $login->Consult($array);
                break;
            case 1:
                $result = $login->Insert();
                break;
            case 2:
                $result = $login->Update();
                break;
            case 3:
                $result = $login->Delete();
                break;
        }
        return $result;
    }

    public function Consult($array)
    {
        $conexion = Conexion::connection();

        $sql = "SELECT * from usuarios WHERE Correo = ? AND Contrasena = ?  AND Estado !=0 ";

        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ss", $array[0], $array[1]);

        $stmt->execute();
        //obtener todos los resultados
        $result = $stmt->get_result();
        if ($result != false) {
            $sql2 = "SELECT Cantidad,Nombre,IdProducto FROM productos WHERE Cantidad <=10 ";
            $resultado = $conexion->query($sql2);
            $response = $resultado->fetch_row();
            if($response[0] != null){
                $nombre = 'Software para todos';
                $destinatario = 'maroces19@gmail.com';
                $asunto = 'Productos Agotandose ';
                $cabeceras = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $mensaje = '<html>'.
    	        '<head><title>AD Solutions</title></head>'.
                '<body><h1>Productos Agotandose</h1>';
                $productos="";
                while($array = $resultado->fetch_row()){
                    $productos .= '<p>Producto:'. $array[1] .' </p> <p>Codigo:'. $array[2] .' </p>';
                }
                $mensaje .= $productos;
                $mensaje .='<hr>'.
                'AD Solutions'.
                '</body>'.
                '</html>';
                $mensajeCompleto = $mensaje . "\n Atentamente: " . $nombre;
                mail($destinatario, $asunto, $mensajeCompleto,$cabeceras);
            }
            
        }
        //asosiarlos a un array fetch row
        return $result->fetch_row();
    }

    public function Insert()
    {
    }

    public function Update()
    {
    }

    public function Delete()
    {
    }
}
