<div class="contenido">
			<?php 
			
				$vista = !empty($_GET['vista']) ? $_GET['vista'] : '404';

				if(isset($vista) and !empty($vista)){

					$file = $vista.".php";

					if(!is_file($file)){
						$file = "404.php";
					}

				}
				
				include $file;
			?>
</div>