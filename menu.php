<?php function mostrar_menu($active = NULL){ ?>
<div class="menu">
	<ul>
		<li><a href="?vista=vistas/escritorio/escritorio" <?php if($active == 'escritorio'){ print "class='active'"; } ?>>Escritorio</a></li>
		<li><a href="?vista=vistas/usuarios/usuarios" <?php if($active == 'usuarios'){ print "class='active'"; } ?>>Usuarios</a></li>
		<li><a href="?vista=vistas/clientes/clientes" <?php if($active == 'clientes'){ print "class='active'"; } ?>>Clientes</a></li>
		<li><a href="?vista=vistas/servicios/servicios" <?php if($active == 'servicios'){ print "class='active'"; } ?>>Servicios</a></li>
		<li><a href="?vista=vistas/mensajes/mensajes" <?php if($active == 'mensajes'){ print "class='active'"; } ?>>Mensajes</a></li>
		<li><a href="?vista=vistas/usuarios/usuarios&operacion=cerrar_sesion">Cerrar Sesion</a></li>
	</ul>
</div>
<?php } ?>