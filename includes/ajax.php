<?php
require_once("mysql_class.php");
require("configuracion.php");
require("funciones.php");
require("email.php");
$op = $_GET['op'];
switch($op)
{
	case 1:
		$sql = "INSERT INTO reservas (fentrada, fsalida, pasajeros, id_thabitacion, nombre, dni, email, telefono, dextra, monto) VALUES('" . $_GET['fentrada'] . "', '" . $_GET['fsalida'] . "', " . $_GET['pasajeros'] . ", " . $_GET['thabitacion'] . ", '" . $_GET['apellido'] . ", " . $_GET['nombre'] . "', '" . $_GET['dni'] . "', '" . $_GET['email'] . "', '" . $_GET['telefono'] . "', '" . $_GET['texto'] . "', " . $_GET['monto'] . ")";
		$resultado = mysql_consulta($sql);
		if(!$resultado)
		{
			echo 0;
			exit();
		}

		echo UltimoId("reservas");
	break;
	case 2:
		
		$mesaje = "<body>";
		$mensaje .= "<div>";
		$mensaje .= "<h3>Reservas Fuerte Calafate</h3>";
		$mensaje .= "<p><b>Apellido y Nombre: </b>" . $_GET['apellido'] . ", " . $_GET['nombre'] . "</p>";
		$mensaje .= "<p><b>DNI: </b>" . $_GET['dni'] . "</p>";
		$mensaje .= "<p><b>Teléfono: </b>" . $_GET['telefono'] . "</p>";
		$mensaje .= "<p><b>email: </b>" . $_GET['email'] . "</p>";
		$mensaje .= "<p><b>Fecha de Entrada: </b>" . ArreglaFechaMostrar($_GET['fentrada']) . "</p>";
		$mensaje .= "<p><b>Fecha Salida: </b>" . ArreglaFechaMostrar($_GET['fsalida']) . "</p>";
		$mensaje .= "<p><b>Tipo de Habitación: </b>" . TraeTipo($_GET['thabitacion']) . "</p>";
		$mensaje .= "<p><b>Cantidad Pasajeros: </b>" . $_GET['pasajeros'] . "</p>";
		$mensaje .= "<p><b>Monto a Abonar: </b>$" . $_GET['monto'] . "</p>";
		$mensaje .= "<p><b>Informacion Adicional: </b><br>" . $_GET['texto'] . "</p>";
		$mensaje .= "</div></body>";
		echo EnviarEmail($mensaje, EMAIL_CONTACTO, $_GET['apellido'] . ", " . $_GET['nombre'], $_GET['email'], "Reservas Fuerte Calafate");
	break;
	case 3:
		$mesaje = "<body>";
		$mensaje .= "<div>";
		$mensaje .= "<h3>Reservas Fuerte Calafate</h3>";
		$mensaje .= "<h4>Ustede recibeeste Email, porque realizo una reserva en www.hotelfuertecalafate.com.ar</h4>";
		$mensaje .= "<p><b>Apellido y Nombre: </b>" . $_GET['apellido'] . ", " . $_GET['nombre'] . "</p>";
		$mensaje .= "<p><b>DNI: </b>" . $_GET['dni'] . "</p>";
		$mensaje .= "<p><b>Teléfono: </b>" . $_GET['telefono'] . "</p>";
		$mensaje .= "<p><b>email: </b>" . $_GET['email'] . "</p>";
		$mensaje .= "<p><b>Fecha de Entrada: </b>" . ArreglaFechaMostrar($_GET['fentrada']) . "</p>";
		$mensaje .= "<p><b>Fecha Salida: </b>" . ArreglaFechaMostrar($_GET['fsalida']) . "</p>";
		$mensaje .= "<p><b>Tipo de Habitación: </b>" . TraeTipo($_GET['thabitacion']) . "</p>";
		$mensaje .= "<p><b>Cantidad Pasajeros: </b>" . $_GET['pasajeros'] . "</p>";
		$mensaje .= "<p><b>Monto a Abonar: </b>$" . $_GET['monto'] . "</p>";
		$mensaje .= "<p><b>Informacion Adicional: </b><br>" . $_GET['texto'] . "</p>";
		$mensaje .= "</div></body>";
		echo EnviarEmail($mensaje, $_GET['email'], $_GET['apellido'] . ", " . $_GET['nombre'], EMAIL_CONTACTO, "Reservas Fuerte Calafate");
	break;
}
?>