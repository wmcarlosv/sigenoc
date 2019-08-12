<?php

	require_once('modelos/modelo.bd.php');

	class modelo_cliente extends modelo_bd{
		public $id,
			   $rif,
			   $razon_social,
			   $direccion,
			   $correo,
			   $telefono,
			   $persona_contacto,
			   $telefono_persona_contacto,
			   $fecha_creacion,
			   $fecha_modificacion;

		public function __construct(){

			$this->id = -1;
			$this->rif = NULL;
			$this->razon_social = NULL;
			$this->direccion = NULL;
			$this->correo = NULL;
			$this->telefono = NULL;
			$this->persona_contacto = NULL;
			$this->telefono_persona_contacto = NULL;
			$this->fecha_creacion = NULL;
			$this->fecha_modificacion = NULL;

			parent::__construct();
		}

		public function buscar_todos(){

			$data = [];

			try{
				$result = $this->conexion->query("select * from clientes");

				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registros Extraidos con Exito!!';
					$clientes = [];

					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['rif'] = $row['rif'];
						$tmp['razon_social'] = $row['razon_social'];
						$tmp['direccion'] = $row['direccion'];
						$tmp['correo'] = $row['correo'];
						$tmp['telefono'] = $row['telefono'];
						$tmp['persona_contacto'] = $row['persona_contacto'];
						$tmp['telefono_persona_contacto'] = $row['telefono_persona_contacto'];
						array_push($clientes, $tmp);
					}
					$data['clientes'] = $clientes;
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
				$result = $this->conexion->query("select * from clientes where id = ".$this->id);
				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registro Extraido con Exito!!';
					$data['cliente'] = $result->fetch_assoc();
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
				$stmt = $this->conexion->prepare("insert into clientes (rif, razon_social,direccion,telefono, correo, persona_contacto, telefono_persona_contacto) values (?,?,?,?,?,?,?)");
				$stmt->bind_param('sssssss',$this->rif, $this->razon_social, $this->direccion, $this->telefono, $this->correo, $this->persona_contacto, $this->telefono_persona_contacto);
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
				$stmt = $this->conexion->prepare("update clientes set rif = ?, razon_social = ?, direccion = ?, correo = ?, telefono = ?, persona_contacto = ?, telefono_persona_contacto = ?, fecha_actualizacion = current_timestamp where id = ?");
				$stmt->bind_param('sssssssi',$this->rif, $this->razon_social, $this->direccion,$this->correo, $this->telefono, $this->persona_contacto, $this->telefono_persona_contacto ,$this->id);
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
				$stmt = $this->conexion->prepare("delete from clientes where id = ?");
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