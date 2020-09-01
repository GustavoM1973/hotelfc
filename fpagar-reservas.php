<?php
require_once("includes/configuracion.php");
include(DIR_INCLUDES . "funciones.php");
require_once(DIR_INCLUDES . "mercadopago.php");
include(DIR_INCLUDES . "header-res.php");
$suma = number_format($_POST['monto'], 2, '.', '');
$mp = new MP (M_CLIENT_ID, M_CLIENT_SECRET);
$bandera = rand(1,9999);
$preference_data = array(
	"items" => array(
		array(
			"title" => M_TITLE,
			"currency_id" => "ARS",
			"quantity" => 1,
			"unit_price" => ($suma * 1)
		)
	),
	"back_urls" => array(
		"success" => HTTP_SERVER . "pago-ok.php?bandera=" . $bandera,
		"failure" => HTTP_SERVER . "pagos-error.php?bandera=" . $bandera,
		"pending" => HTTP_SERVER . "pagos-pendiente.php?bandera=" . $bandera
	),
	"auto_return" => "all",
	"payment_methods" => array(
		"excluded_payment_types" => array(
			array("id"=>"ticket"), 
			array("id"=>"bank_transfer"),
			array("id"=>"atm")
			)									
		),
	"installments" => 12
);
$preference = $mp->create_preference($preference_data);

?>
<section>
<h1><?php echo TraducirTexto("Reservas", $_SESSION['leng']);?></h1>
<reservas>
	<form id="miForm" onsubmit="return ProcesarReserva(this);">
		<input type="hidden" name="pasajeros" value="<?php echo $_POST['pasajeros'];?>">
		<input type="hidden" name="thabitacion" value="<?php echo $_POST['thabitacion'];?>">
		<input type="hidden" name="monto" value="<?php echo $suma;?>">
		<input type="hidden" name="fentrada" value="<?php echo $entrada;?>">
		<input type="hidden" name="fsalida" value="<?php echo $salida;?>">
		<input type="hidden" name="bandera" value="<?php echo $bandera;?>">
		<label><?php echo TraducirTexto("Apellido", $_SESSION['leng']);?>:</label>
		<input type="text" name="apellido" required><br><br>
		<label><?php echo TraducirTexto("Nombre", $_SESSION['leng']);?>:</label>
		<input type="text" name="nombre" required><br><br>
		<label><?php echo TraducirTexto("Documento", $_SESSION['leng']);?>:</label>
		<input type="text" name="dni" required><br><br>
		<label><?php echo TraducirTexto("Teléfono", $_SESSION['leng']);?>:</label>
		<input type="tel" name="telefono" required><br><br>
		<label><?php echo TraducirTexto("Email", $_SESSION['leng']);?>:</label>
		<input type="email" name="email" required><br><br>
		<label><?php echo TraducirTexto("Datos Extras", $_SESSION['leng']);?>:</label>
		<textarea name="dextra"></textarea><br><br>
		<center><button type="submit"><?php echo TraducirTexto2("Enviar datos", "es", $_SESSION['leng']);?></button></center>
	</form>
	
	<div id="pago" class="pago">
		<div id="mensaje">
		</div>
		<br>
		<div class="divo">
			<p><?php echo TraducirTexto("Usted abonará el monto de", $_SESSION['leng']);?> $ <?php echo FormatoPrecio($_POST['monto']);?> <?php echo TraducirTexto("por la reserva de una habitación", $_SESSION['leng']) . " " . TraeTipo($_POST['thabitacion']) . " " . TraducirTexto("para ser ocupada desde el", $_SESSION['leng']) . " " . ArreglaFechaMostrar($_POST['fentrada']) . " " . TraducirTexto("hasta el", $_SESSION['leng']) . " " . ArreglaFechaMostrar($_POST['fsalida']);?></p>
			<p><b><?php echo TraducirTexto("Si decea abonar con transferencia bancaria, pongace en contacto con nosotros.", $_SESSION['leng']);?></b></p><br>
			<br><p><input type="checkbox" id="aceptar" onclick="Habilitar('idb', 'aceptar');"> <?php echo TraducirTexto("Aceptar", $_SESSION['leng']);?><a class="link"onclick="MostrarT('block');"> <?php echo TraducirTexto("terminos y condiciones", $_SESSION['leng']);?></a>.</p>
			<br><br><br><center><span class="lightblue-rn-m-tr" id="idb"><a href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout"><?php echo TraducirTexto("Abonar con", $_SESSION['leng']);?> MercadoPago</a></span></center>
			<script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
		</div>
		<img src="imagenes/mercadopago.jpg" alt="<?php echo ALT;?>">
	<div>
</reservas>
</section>
<div id="terminos" class="terminos2">&nbsp;
	<div class="terminos">
				<a onclick="MostrarT('none');" class="fal"><i class="fa fa-times-circle"></i></i></a>
				adasd
				asd
				asd
				as
				as
				d
				as
				a
	</div>
</div>
<?php
include(DIR_INCLUDES . "footer.php");
?>
<script type="text/javascript">
	function ProcesarReserva(form)
	{
		var pasajeros = form.pasajeros.value;
		var thabitacion = form.thabitacion.value;
		var monto = form.monto.value;
		var fentrada = form.fentrada.value;
		var fsalida = form.fsalida.value;
		var apellido = form.apellido.value;
		var nombre = form.nombre.value;
		var dni = form.dni.value;
		var telefono = form.telefono.value;
		var email = form.email.value;
		var texto = form.dextra.value;
		var bandera = form.bandera.value;
		var urlMysqlwsphp = "includes/ajax.php";
		var req = new ajaxRequest();
		var url = urlMysqlwsphp + "?op=1&bandera=" + bandera + "&pasajeros=" + pasajeros + "&thabitacion=" + thabitacion + "&monto=" + monto + "&fentrada=" + fentrada + "&fsalida=" + fsalida + "&apellido=" + apellido + "&nombre=" + nombre + "&dni=" + dni + "&telefono=" + telefono + "&email=" + email + "&texto=" + texto + "&tiempo=" + new Date().getTime();
		req.open("GET", url, false)
		req.send(null);
		var res1 = req.responseText;
		var req = new ajaxRequest();
		var url = urlMysqlwsphp + "?op=2&pasajeros=" + pasajeros + "&thabitacion=" + thabitacion + "&monto=" + monto + "&fentrada=" + fentrada + "&fsalida=" + fsalida + "&apellido=" + apellido + "&nombre=" + nombre + "&dni=" + dni + "&telefono=" + telefono + "&email=" + email + "&texto=" + texto + "&tiempo=" + new Date().getTime();
		req.open("GET", url, false)
		req.send(null);
		var res2 = req.responseText;
		var req = new ajaxRequest();
		var url = urlMysqlwsphp + "?op=3&pasajeros=" + pasajeros + "&thabitacion=" + thabitacion + "&monto=" + monto + "&fentrada=" + fentrada + "&fsalida=" + fsalida + "&apellido=" + apellido + "&nombre=" + nombre + "&dni=" + dni + "&telefono=" + telefono + "&email=" + email + "&texto=" + texto + "&tiempo=" + new Date().getTime();
		req.open("GET", url, false)
		req.send(null);
		var res3 = req.responseText;
		if(res1 == 0 || res2 == 0 || res3 == 0)
		{
			document.getElementById("mensaje").innerHTML = "<h5>Hubo un error, intente nuevamente</h5>";
		}
		if(res1 && res2 && res3)
		{
			document.getElementById("miForm").reset();
			document.getElementById("mensaje").innerHTML = "<h5><?php echo TraducirTexto('La información se envio correctamente, solo falta abonar la reserva', $_SESSION['leng']);?></h5>";
			document.getElementById("miForm").style.display = "none";			
		}
		document.getElementById("pago").style.display = "block";
		return false;
	}
	function ajaxRequest()
	{
		try {
			var request = new XMLHttpRequest();
		} catch (e1) {
			try {
				request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e2) {
				try {
					request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e3) {
					request = false;
				}
			}
		}
		return request;
	}
	function Habilitar(id, name)
	{
		if(document.getElementById(name).checked)
		{
			document.getElementById(id).style['pointer-events'] = "auto";
			document.getElementById(id).style.opacity = "1";
		}
		else
		{
			document.getElementById(id).style['pointer-events'] = "none";
			document.getElementById(id).style.opacity = "0.5";
		}
	}
	function MostrarT(m)
	{
		document.getElementById('terminos').style.display = m;
	}

</script>
