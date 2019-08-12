<?php
	include 'controladores/controlador.mensaje.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('mensajes');

	if($_GET['accion'] == 'crear'){
		$title = "Nuevo Mensaje";
	}else{
		$title = "Reenviar Mensaje";
	}	

	$action = "?vista=vistas/mensajes/mensajes&operacion=insertar";
?>

<div id="oscuro"></div>
<div id="resultado">
	<div class="panel" style="background: white !important;">
		<h2>Resultado</h2>
		<div class="cuerpo-panel">
			<table class="table">
				<thead>
					<tr>
						<td>Nombres</td>
						<td>-</td>
					</tr>
				</thead>
				<tbody id="cargar_contenido"></tbody>
				<tbody>
					<tr>
						<td colspan="2" align="right"><a href="#" onclick="cerrar();" id="cerrar_ventana">Cerrar Ventana</a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="panel">
	<h2><?=$title?></h2>
	<div class="cuerpo-panel">
			<form method="POST" onsubmit="return enviar()" action="<?=$action?>" autocomplete="off">

			<table class="table">
				<tbody>
					<tr>
						<td>Titulo: </td>
						<td>Contenido</td>
					</tr>
					<tr>
						<td style="vertical-align: top;"><input type="text" name="titulo" value="<?=@$data->titulo?>" id="titulo" /></td>
						<td><textarea cols="25" name="contenido" id="contenido"><?=@$data->contenido?></textarea></td>
					</tr>
					<tr>
						<td>
							<table class="table">
								<thead>
									<tr>
										<td>Cliente</td>
										<td>-</td>
									</tr>
									<tr>
										<td><input type="text" id="clientes"></td>
										<td><a href="#" onclick="buscar('clientes','clientes');">Buscar</a></td>
									</tr>
								</thead>
								<tbody id="contenedor_clientes">
									<?php 
										if(!empty($clientes)):
											for($c=0;$c < count($clientes); $c++): 
									?>
												<tr>
													<td><input type="hidden" name="input_clientes[]" value="<?=$clientes[$c]['id']?>"><?=$clientes[$c]['nombre']?></td>
													<td><a href='#' onclick='eliminar_detalle(this);'>Eliminar Detalle</a></td>
												</tr>
									<?php 
											endfor;
										endif;
									?>
								</tbody>
							</table>
						</td>
						<td>
							<table class="table">
								<thead>
									<tr>
										<td>Servicio</td>
										<td>-</td>
									</tr>
									<tr>
										<td><input type="text" id="servicios"></td>
										<td><a href="#" onclick="buscar('servicios','servicios');">Buscar</a></td>
									</tr>
								</thead>
								<tbody id="contenedor_servicios">
									<?php 
										if(!empty($servicios)):
											for($s=0;$s < count($servicios); $s++): 
									?>
												<tr>
													<td><input type="hidden" name="input_servicios[]" value="<?=$servicios[$s]['id']?>"><?=$servicios[$s]['nombre']?></td>
													<td><a href='#' onclick='eliminar_detalle(this);'>Eliminar Detalle</a></td>
												</tr>
									<?php 
											endfor;
										endif; 
									?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table">
				<tbody>
					<tr>
						<td><button>Enviar</button></td>
						<td><a href="?vista=vistas/mensajes/mensajes">Cancelar</a></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>