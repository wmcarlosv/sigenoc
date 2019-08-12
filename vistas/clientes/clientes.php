<?php
	include 'controladores/controlador.cliente.php';
	if($obj->conectado == 'no'){
		print "<script>location.href='?vista=vistas/sesion/iniciar.sesion';</script>";
	}
	mostrar_menu('clientes');
?>

<div class="panel">
	<h2>Clientes</h2>
	<div class="cuerpo-panel">
		<a class="boton" href="?vista=vistas/clientes/acciones.clientes&accion=crear">Nuevo</a>
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Rif</td>
					<td>Razon Social</td>
					<td>Correo</td>
					<td>Telefono</td>
					<td>-</td>
				</tr>
			</thead>
			<tbody>
				<?php
					if(!empty($data['clientes'])): 
						foreach($data['clientes'] as $cliente): 
				?>
							<tr>
								<td><?=$cliente['id']?></td>
								<td><?=$cliente['rif']?></td>
								<td><?=$cliente['razon_social']?></td>
								<td><?=$cliente['correo']?></td>
								<td><?=$cliente['telefono']?></td>
								<td>
									<a href="?vista=vistas/clientes/acciones.clientes&accion=editar&operacion=buscarxid&id=<?=$cliente['id']?>">Editar</a>
									<a onclick="eliminar(event);" href="?vista=vistas/clientes/clientes&operacion=eliminar&id=<?=$cliente['id']?>">Eliminar</a>
								</td>
							</tr>
				<?php 
						endforeach;
					endif;
				?>
			</tbody>
		</table>
	</div>
</div>