<?php

	session_start();

	class modelo_bd {

		private $servidor,
				$usuario,
				$clave,
				$base_de_datos;

		public $conectado, $conexion;

		public function __construct(){

			$this->servidor = "";
			$this->usuario = "";
			$this->clave = "";
			$this->base_de_datos = "";
			$this->conectado = 'no';
			$this->conectar();
			$this->en_sesion();
		}

		private function conectar(){

			$this->conexion = new mysqli($this->servidor, $this->usuario, $this->clave, $this->base_de_datos);

			if($this->conexion->connect_errno){
				echo "Error al tratar de conectara la base de datos \n";
				echo "Err No: " . $this->mysqli->connect_errno . "\n";
    			echo "Error Des: " . $this->mysqli->connect_error . "\n";
    			exit;
			}

		}

		private function en_sesion(){
			$sesion = !empty($_SESSION['en_sesion']) ? $_SESSION['en_sesion']: NULL;
			if(isset($sesion) and !empty($sesion)){
				$this->conectado = 'si';
			}
		}

	}