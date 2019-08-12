<?php
	require 'modelos/modelo.escritorio.php';
	$obj = new modelo_escritorio();

	$table = $_GET['table'];
	$q = $_GET['q'];

	$data = [];

	if($table == 'clientes'){
		$data = $obj->buscar_clientes($q);
	}else{
		$data = $obj->buscar_servicios($q);
	}

	print json_encode($data);