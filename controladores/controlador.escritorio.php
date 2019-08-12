<?php
	require 'modelos/modelo.escritorio.php';
	$obj = new modelo_escritorio();

	$servicios = $obj->getCount('servicios');
	$clientes = $obj->getCount('clientes');
	$mensajes = $obj->getCount('mensajes');

	$lista_mensajes = $obj->getLastMessages();