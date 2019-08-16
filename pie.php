		<div class="pie">
			<p>Sigenoc Todos los Derechos Reservados 2019</p>
		</div>
	</div>
<script type="text/javascript">
	load = function(){
		var mensaje = "<?=!empty($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?>";
		if(mensaje){
			alert(mensaje);
		}
	}

	eliminar = function(e){
		if(!confirm("Estas seguro de eliminar este registro?")){
			e.preventDefault();
		}
	}

	buscar = function(table, f){
		var oscuro = document.getElementById("oscuro");
		var resultado = document.getElementById("resultado");
		var s = document.getElementById(f).value;
		oscuro.style.display = "block";
		resultado.style.display = "block";

		ajax(table,s);

		document.getElementById(f).value = "";
	}

	cerrar = function(){
		var oscuro = document.getElementById("oscuro");
		var resultado = document.getElementById("resultado");

		oscuro.style.display = "none";
		resultado.style.display = "none";
	}

	ajax = function(table, q){

	  var xhttp = new XMLHttpRequest();
	  var url = "ajax.php?table="+table+"&q="+q;

	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	     	let data = JSON.parse(this.responseText);
	     	let contenido = document.getElementById("cargar_contenido");
	     	let html="";
	     	contenido.innerHTML = "";

	     	for(var i = 0; i < data.length; i++){
	     		html+="<tr>";
		     		html+="<td>"+data[i].nombre+"</td>";
		     		html+="<td><a href='#' onclick=\"agregar_detalle('"+data[i].id+"','"+data[i].nombre+"','"+table+"')\">Agregar Detaller</a></td>";
	     		html+="</tr>";
	     	}

	     	contenido.innerHTML+=html;
	     	html = "";
	    }
	  };

	  xhttp.open("GET", url, true);
	  xhttp.send();
	}

	agregar_detalle = function(i,n,t){
		var contenedor = document.getElementById("contenedor_"+t);
		var html = "<tr>";
				html+="<td><input type='hidden' name='input_"+t+"[]' value='"+i+"' />"+n+"</td>";
				html+="<td><a href='#' onclick='eliminar_detalle(this);'>Eliminar Detalle</a></td>";
			html+="</tr>";

		contenedor.innerHTML+=html;
		html = "";
		cerrar();
	}

	eliminar_detalle = function(e){
		var td = e.parentNode;
		var tr = td.parentNode;
		var tbody = tr.parentNode;
			tbody.removeChild(tr);
	}

	function validateBeforeSend(){
		var inputs = document.querySelectorAll("input,textarea")
		var cont_errors = 0;
		var message = "Se han presentado los Siguientes Errores:\n";
		for(var i=0;i < inputs.length; i++){
			if(inputs[i].hasAttribute("data-validate")){
				var vals = inputs[i].getAttribute("data-validate").split(",");
				for(var e=0;e < vals.length; e++){
					switch(vals[e]){
						case 'required':
							if(!required(inputs[i].value)){
								message+="--El "+inputs[i].name+" es Obligatorio\n";
								cont_errors++;
							}
						break;
						case 'email':
							if(!isValidEmail(inputs[i].value)){
								message+="--El "+inputs[i].name+" debe tener el formato Correcto\n";
								cont_errors++;
							}
						break;
						case 'numeros':
							if(!onlyNumber(inputs[i].value)){
								message+="--El "+inputs[i].name+" solo debe contener Numeros\n";
								cont_errors++;
							}
						break;
					}
				}
			}
		}

		if(cont_errors > 0){
			alert(message);
			return false;
		}else{
			if(!confirm("Estas seguro de Procesar esta Información?")){
				return false;
			}else{
				return true;	
			}
		}
	}

	function required(input){
		var regex = /^\s*$/;
		if(regex.test(input)) {
	        return false;
	    }else {
	        return true;
	    }
	}

	function onlyNumber(input){
		var numbers = /^[0-9]+$/;
		if(input.match(numbers)) {
	        return true;
	    }else {
	        return false;
	    }
	}

	function isValidEmail(mail) { 
	  return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(mail); 
	}

	window.onload = load();
</script>
</body>
</html>