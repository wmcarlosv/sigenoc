<?php
	require_once dirname(__FILE__).'/../libreria_correo/mailer/src/Exception.php';
	require_once dirname(__FILE__).'/../libreria_correo/mailer/src/PHPMailer.php';
	require_once dirname(__FILE__).'/../libreria_correo/mailer/src/SMTP.php';

	require_once('modelos/modelo.bd.php');

	class modelo_mensaje extends modelo_bd{
		public $id,
			   $titulo,
			   $contenido,
			   $usuario_id,
			   $fecha_creacion,
			   $fecha_modificacion;

		public function __construct(){

			$this->id = -1;
			$this->title = NULL;
			$this->contenido = NULL;
			if(!empty($_SESSION['usuario'])){
				$this->usuario_id = $_SESSION['usuario']['id'];
			}else{
				$this->usuario_id = NULL;	
			}
			
			$this->fecha_creacion = NULL;
			$this->fecha_modificacion = NULL;

			parent::__construct();
		}

		public function buscar_todos(){

			$data = [];

			try{
				$result = $this->conexion->query("select * from mensajes order by fecha_creacion DESC");

				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registros Extraidos con Exito!!';
					$mensajes = [];

					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['titulo'] = $row['titulo'];
						$tmp['contenido'] = $row['contenido'];
						$tmp['usuario_id'] = $row['usuario_id'];
						array_push($mensajes, $tmp);
					}
					$data['mensajes'] = $mensajes;
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
				$result = $this->conexion->query("select * from mensajes where id = ".$this->id);
				if($result->num_rows > 0){
					$data['error'] = 0;
					$data['mensaje'] = 'Registro Extraido con Exito!!';
					$data['mensaje'] = $result->fetch_assoc();
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
				$stmt = $this->conexion->prepare("insert into mensajes (titulo, contenido, usuario_id) values (?,?,?)");
				$stmt->bind_param('ssi',$this->titulo, $this->contenido, $this->usuario_id);
				$stmt->execute();
				$this->id = $this->conexion->insert_id;
				$data['error'] = 0;
				$data['mensaje'] = 'Se ha enviado la informacion de manera Exitosa!!';
				$stmt->close();
			}catch(Exception $e){
				$data['error'] = 0;
				$data['mensaje'] = 'Ocurrio un error al tratar de enviar la Informacion!!';
			}

			return $data;
		}

		public function eliminar(){
			$data = [];
			$this->eliminar_detalle('mensaje_clientes');
			$this->eliminar_detalle('mensaje_servicios');

			try{
				$stmt = $this->conexion->prepare("delete from mensajes where id = ?");
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

		public function insertar_detalle($table,$field, $field_id){

			$data = [];
			try{
				if($this->conexion->query('insert into '.$table.'('.$field.', mensaje_id) values ('.$field_id.','.$this->id.')')){
					$data['error'] = 0;
					$data['mensaje'] = 'Registrado con Exito!!';
				}else{
					$data['error'] = 1;
					$data['mensaje'] = 'Error al registrar!!';
				}
			}catch(Exception $e){
				$data['error'] = 2;
				$data['mensaje'] = 'Error de Consulta!!';
			}

			return $data;

		}

		public function eliminar_detalle($table){

			$data = [];
			try{
				if($this->conexion->query('delete from '.$table.' where mensaje_id = '.$this->id)){
					$data['error'] = 0;
					$data['mensaje'] = 'Eliminado con Exito!!';
				}else{
					$data['error'] = 1;
					$data['mensaje'] = 'Error al Eliminar!!';
				}
			}catch(Exception $e){
				$data['error'] = 2;
				$data['mensaje'] = 'Error de Consulta!!';
			}

			return $data;

		}

		public function traer_servicios(){
			$data = [];

			try{
				$result = $this->conexion->query("select s.nombre, s.id from mensaje_servicios as ms inner join servicios as s on s.id = ms.servicio_id where ms.mensaje_id = ".$this->id);
				if($result->num_rows > 0){
					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['nombre'] = $row['nombre'];
						array_push($data, $tmp);
					}
				}
			}catch(Exception $e){

			}

			return $data;
		}

		public function traer_clientes(){
			$data = [];

			try{
				$result = $this->conexion->query("select concat(c.razon_social,'',c.correo) as nombre, c.id from mensaje_clientes as mc inner join clientes as c on c.id = mc.cliente_id where mc.mensaje_id = ".$this->id);
				if($result->num_rows > 0){
					while($row = $result->fetch_array()){
						$tmp['id'] = $row['id'];
						$tmp['nombre'] = $row['nombre'];
						array_push($data, $tmp);
					}
				}
			}catch(Exception $e){

			}

			return $data;
		}

		public function send_email($destinatarios, $titulo, $mensaje, $servicios){
			$data = true;
			$mail = new \PHPMailer\PHPMailer\PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->Host       = 'smtp.gmail.com';
			$mail->Port       = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth   = true;
			$mail->Username   = "jquerysencillo@gmail.com";
			$mail->Password   = "Car2244los*";
			$mail->SetFrom('jquerysencillo@gmail.com', 'Sigenoc Administrativo');

			$lista = "<ul>";
				for($i=0;$i < count($servicios); $i++){
					$lista.="<li>".$servicios[$i]."</li>";
				}
			$lista .= "</ul>";
			
			while (list ($key, $val) = each ($destinatarios)) {
				$mail->AddAddress($val);
			}

			$mail->Subject = 'Sigenoc Informativo - '.$titulo;
			$mail->MsgHTML("<p>".$mensaje."</p><p>Este Mensaje es Valido para los Siguientes Servicios: </p>".$lista);
			$mail->AltBody = '';

			if(!$mail->Send()) {
			  $data = false;
			}

			return $data;
		}
	}