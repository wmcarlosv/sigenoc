<?php
	require 'modelos/modelo.bd.php';

	class modelo_escritorio extends modelo_bd{
		public function __construct(){
			parent::__construct();
		}

		public function getCount($table){
			$cantidad = 0;
			try{
				$result = $this->conexion->query("select count(*) as cantidad from ".$table);
				$cantidad = $result->fetch_assoc()['cantidad'];
			}catch(Exception $e){

			}

			return $cantidad;
		}

		public function getLastMessages(){
			$mensajes = [];
			try{
				$result = $this->conexion->query("select * from mensajes order by fecha_creacion DESC limit 10");
				while($row = $result->fetch_array()){
					$tmp['id'] = $row['id'];
					$tmp['titulo'] = $row['titulo'];
					$tmp['contenido'] = $row['contenido'];
					$tmp['fecha'] = date('d-m-Y',strtotime($row['fecha_creacion']));
					array_push($mensajes, $tmp);
				}
			}catch(Exception $e){

			}

			return $mensajes;
		}

		public function buscar_clientes($q){
			$data = [];
			try{
				$result = $this->conexion->query("select id, concat(razon_social,' ',correo) as nombre from clientes where razon_social like '%".$q."%' OR correo like '%".$q."%'");

				while($row = $result->fetch_array()){
					$tmp['id'] = $row['id'];
					$tmp['nombre'] = $row['nombre'];
					array_push($data, $tmp);
				}

				$result->close();
			}catch(Exception $e){

			}

			return $data;
		}

		public function buscar_servicios($q){
			$data = [];
			try{
				$result = $this->conexion->query("select id, nombre from servicios where nombre like '%".$q."%'");

				while($row = $result->fetch_array()){
					$tmp['id'] = $row['id'];
					$tmp['nombre'] = $row['nombre'];
					array_push($data, $tmp);
				}

				$result->close();
			}catch(Exception $e){

			}

			return $data;
		}

	}