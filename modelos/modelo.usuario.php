<?php

	require_once('modelos/modelo.bd.php');

	class modelo_usuario extends modelo_bd{
		public $id,
			   $nombre,
			   $correo,
			   $telefono,
			   $clave,
			   $fecha_creacion,
			   $fecha_modificacion;

		public function __construct(){

			$this->id = -1;
			$this->nombre = NULL;
			$this->correo = NULL;
			$this->telefono = NULL;
			$this->clave = NULL;
			$this->fecha_creacion = NULL;
			$this->fecha_modificacion = NULL;

			parent::__construct();
		}

		public function buscar_todos(){

			$data = [];

			try{
				$result = $this->conexion->query("select * from usuarios");

				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registros Extraidos con Exito!!';
					$usuarios = [];

					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['nombre'] = $row['nombre'];
						$tmp['correo'] = $row['correo'];
						$tmp['telefono'] = $row['telefono'];
						array_push($usuarios, $tmp);
					}
					$data['usuarios'] = $usuarios;
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
				$result = $this->conexion->query("select * from usuarios where id = ".$this->id);
				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registro Extraido con Exito!!';
					$data['usuario'] = $result->fetch_assoc();
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
				$stmt = $this->conexion->prepare("insert into usuarios (nombre, correo, telefono, clave) values (?,?,?,md5('123456'))");
				$stmt->bind_param('sss',$this->nombre, $this->correo, $this->telefono);
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
				$stmt = $this->conexion->prepare("update usuarios set nombre = ?, correo = ?, telefono = ?, fecha_actualizacion = current_timestamp where id = ?");
				$stmt->bind_param('sssi',$this->nombre, $this->correo, $this->telefono, $this->id);
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
				$stmt = $this->conexion->prepare("delete from usuarios where id = ?");
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

		public function iniciar_sesion(){
			$data = [];
			try{
				$stmt = $this->conexion->prepare("select * from usuarios where correo = ? and clave = ?");
				$this->clave = md5($this->clave);
				$stmt->bind_param('ss',$this->correo, $this->clave);
				$stmt->execute();
				$result = $stmt->get_result();

				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Inicio Sesion de manera Exitosa!!';
					$data['usuario'] = $result->fetch_assoc();
				}else{
					$data['error'] = 1;
					$data['mensaje'] = 'No existe el Usuario Solicitado!!';
				}

				$stmt->close();
			}catch(Exception $e){
				$data['error'] = 2;
				$data['mensaje'] = 'Error al realizar la Consulta!!';
			}

			return $data;
		}
		
	}