<?php
	include 'controladores/controlador.usuario.php';
	if($obj->conectado == 'si'){
		print "<script>location.href='?vista=vistas/escritorio/escritorio';</script>";
	}
?>
<div class="login">
	<h1>Iniciar Sesi&oacute;n</h1>
	<form method="POST" autocomplete="off" action="?vista=vistas/sesion/iniciar.sesion&operacion=iniciar_sesion">
		<table>
			<tr>
				<td>Correo: </td>
				<td><input type="text" name="correo" id="correo"></td>
			</tr>
			<tr>
				<td>Clave: </td>
				<td><input type="password" name="clave" id="clave"></td>
			</tr>
			<tr>
				<td><a href="?vista=vistas/sesion/recuperar.clave">Recuperar Clave</a></td>
				<td><button>Iniciar Sesion</button></td>
			</tr>
		</table>
	</form>
</div>