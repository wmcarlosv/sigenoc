<div class="contenido">
			<?php 
			
				$vista = !empty($_GET['vista']) ? $_GET['vista'] : NULL;

				if(isset($vista) and !empty($vista)){

					$file = $vista.".php";

					if(!is_file($file)){
						$file = "404.php";
					}

				}else{
					$file = "vistas/sesion/iniciar.sesion.php";
				}
				
				include $file;
			?>
</div>