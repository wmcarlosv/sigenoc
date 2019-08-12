<?php

	require_once('modelos/modelo.bd.php');

	class modelo_servicio extends modelo_bd{
		public $id,
			   $nombre,
			   $fecha_creacion,
			   $fecha_modificacion;

		public function __construct(){

			$this->id = -1;
			$this->nombre = NULL;
			$this->fecha_creacion = NULL;
			$this->fecha_modificacion = NULL;

			parent::__construct();
		}

		public function buscar_todos(){

			$data = [];

			try{
				$result = $this->conexion->query("select * from servicios");

				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registros Extraidos con Exito!!';
					$servicios = [];

					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['nombre'] = $row['nombre'];
						array_push($servicios, $tmp);
					}
					$data['servicios'] = $servicios;
					$result->close();
				}else{
					$data['error'] = 1;
					$data['mensaje'] = 'No se encontraron Datos!!';
				}
			}catch(Exception $e){
				$data['error'] = 2;
				$data['mensaje'] = 'Error al tratar de realizar la Consulta!!';
			}

			return $data;

		}

		public function buscarxid(){
			$data = [];

			try{
				$result = $this->conexion->query("select * from servicios where id = ".$this->id);
				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registro Extraido con Exito!!';
					$data['servicio'] = $result->fetch_assoc();
					$result->close();
				}else{
					$data['error'] = 1;
					$data['mensaje'] = 'No se encontraron Datos!!';
				}
			}catch(Exception $e){
				$data['error'] = 2;
				$data['mensaje'] = 'Error al tratar de realizar la Consulta!!';
			}

			return $data;
		}

		public function registrar(){
			$data = [];

			try{
				$stmt = $this->conexion->prepare("insert into servicios (nombre) values (?)");
				$stmt->bind_param('s',$this->nombre);
				$stmt->execute();
				$data['error'] = 0;
				$data['mensaje'] = 'Registro Insertado con Exito!!';
				$stmt->close();
			}catch(Exception $e){
				$data['error'] = 0;
				$data['mensaje'] = 'Ocurrio un error al tratar de insertar el Registro!!';
			}

			return $data;
		}

		public function actualizar(){
			$data = [];

			try{
				$stmt = $this->conexion->prepare("update servicios set nombre = ?, fecha_actualizacion = current_timestamp where id = ?");
				$stmt->bind_param('si',$this->nombre, $this->id);
				$stmt->execute();
				$data['error'] = 0;
				$data['mensaje'] = 'Registro Actualizado con Exito!!';
				$stmt->close();
			}catch(Exception $e){
				$data['error'] = 0;
				$data['mensaje'] = 'Ocurrio un error al tratar de actualizar el Registro!!';
			}

			return $data;
		}

		public function eliminar(){
			$data = [];

			try{
				$stmt = $this->conexion->prepare("delete from servicios where id = ?");
				$stmt->bind_param('i',$this->id);
				$stmt->execute();
				$data['error'] = 0;
				$data['mensaje'] = 'Registro Eliminado con Exito!!';
				$stmt->close();
			}catch(Exception $e){
				$data['error'] = 0;
				$data['mensaje'] = 'Ocurrio un error al tratar de eliminar el Registro!!';
			}

			return $data;
		}	
	}