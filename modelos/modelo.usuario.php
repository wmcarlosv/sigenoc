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

		public function recuperar_clave(){
			$data = [];

			try{
				$result = $this->conexion->query("select * from usuarios where correo = '".$this->correo."'");
				if($result->num_rows > 0){
					$this->clave = $this->generateRandomString();
					if($this->conexion->query("update usuarios set clave = md5('".$this->clave."') where correo = '".$this->correo."'")){
						$this->enviar_clave_reseteada();
						$data['error'] = 0;
						$data['mensaje'] = 'Clave Resetada con Exito!!';
					}else{
						$data['error'] = 1;
						$data['mensaje'] = 'Error al tratar de resetear la clave!!';
					}
				}else{
					$data['error'] = 2;
					$data['mensaje'] = 'No se encontraron Datos!!';
				}
			}catch(Exception $e){
				$data['error'] = 3;
				$data['mensaje'] = 'Error al tratar de realizar la Consulta!!';
			}

			return $data;
		}

		public function enviar_clave_reseteada(){
			require_once dirname(__FILE__).'/../libreria_correo/mailer/src/Exception.php';
			require_once dirname(__FILE__).'/../libreria_correo/mailer/src/PHPMailer.php';
			require_once dirname(__FILE__).'/../libreria_correo/mailer/src/SMTP.php';

			$data = true;
			$mail = new \PHPMailer\PHPMailer\PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->Host       = 'premium53.web-hosting.com';
			$mail->Port       = 465;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPAuth   = true;
			$mail->Username   = "cvargas@frontuari.net";
			$mail->Password   = "Car2244los*";
			$mail->SetFrom('cvargas@frontuari.net', 'Sigenoc Administrativo');
			$mail->AddAddress($this->correo);
			$mail->Subject = 'Sigenoc - Reseteo de Clave';
			$mail->MsgHTML("<p>Se ha reseteado su clave de forma exitosa, esta es su nueva clave: <b>".$this->clave."</b></p>");
			$mail->AltBody = '';

			if(!$mail->Send()) {
			  $data = false;
			}

			return $data;
		}
		

		public function generateRandomString($length = 8) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}
	}