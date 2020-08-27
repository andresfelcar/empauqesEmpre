<?php
@session_start();
require_once "controller/Controller.php";

$result = $_SESSION['user'];
if ($result == null) {
    header("Location:index.php");
}

$invoice =  new Controller();

if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->Invoices(0,array(3,$_GET['invoice_id']));	
	$itemsF_C=$invoiceValues[0]->fetch_row();
}
date_default_timezone_set('America/Bogota');
$invoiceDate = date('d-m-Y - H:i:s', time());
$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>Orden de pedido</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	
	<b>CLIENTE</b><br />
	Nombres : '.$itemsF_C[5].'<br /> 
	Telefono: '.$itemsF_C[6].'<br />
	Vendedor : '.$result[1].'<br />
	<b>Ventas por mostrador</b><br />
	</td>
	<td width="35%">         
	Orden de pedido No. : '.$itemsF_C[0].'<br />
	Fecha: '.$invoiceDate.'<br />
	Carlos E Rodriguez<br/>
	Nit: 98620440-4<br/>        
	Direccion: Carre 53#58-78<br/>
	Medellin Antioquia<br/>   
	Casatecnico@Outlook.com</td>
	</tr>
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="left">Codigo</th>
	<th align="left">Nombre Producto</th>
	<th align="left">Cantidad</th>
	<th align="left">Precio</th>
	<th align="left">Total.</th> 
	</tr>';
$count = 0;
while($itemsD_P=$invoiceValues[1]->fetch_row()){   

	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$itemsD_P[0].'</td>
	<td align="left">'.$itemsD_P[1].'</td>
	<td align="left">'.$itemsD_P[2].'</td>
	<td align="left">'.$itemsD_P[3].'</td>
	<td align="left">'.$itemsD_P[2]*$itemsD_P[3].'</td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Total con descuento</b></td>
	<td align="left"><b>'.$itemsF_C[2].'</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5">Pagado Con:</td>
	<td align="left">'.$itemsF_C[3].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Devulto:</b></td>
	<td align="left">'.$itemsF_C[4].'</td>
	</tr>';
$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'Invoice-'.$itemsF_C[0].'.pdf';

require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>
   