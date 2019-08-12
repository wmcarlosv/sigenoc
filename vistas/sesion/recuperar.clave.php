<?php
	include 'controladores/controlador.usuario.php';
	if($obj->conectado == 'si'){
		print "<script>location.href='?vista=vistas/escritorio/escritorio';</script>";
	}
?>
<div class="login">
	<h1>Recuperar Clave</h1>
	<form method="POST" autocomplete="off" action="?vista=vistas/sesion/iniciar.sesion&operacion=recuperar_clave">
		<table>
			<tr>
				<td>Correo: </td>
				<td><input type="text" name="correo" id="correo"></td>
			</tr>
			<tr>
				<td><a href="?vista=vistas/sesion/iniciar.sesion">Volver</a></td>
				<td><button>Recuperar</button></td>
			</tr>
		</table>
	</form>
</div>