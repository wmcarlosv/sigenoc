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

	enviar = function(e){
		if(!confirm("Estas seguro de enviar este Mensaje?")){
			return false;
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

	window.onload = load();
</script>
</body>
</html>