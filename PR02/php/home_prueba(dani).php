<html>
	<head>
		<title></title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="../css/diseñocss.css"/>
	</head>
	<body>	
			<?php 
			$conexion=mysqli_connect("localhost", "root", "", "1718_projecte_2");
			if(!$conexion){
			    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
			    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
			    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
			    exit;
			    } else {
				//Mostramos los datos.
					$user=$_REQUEST['user']; 
					$nombre=("SELECT `Nombre_Usuario`, `Apellido1_Usuario`,`Apellido2_Usuario` FROM tbl_user WHERE Login_Usuario = '$user'");
					$consulta=mysqli_query($conexion,$nombre);
					$numero = mysqli_num_rows($consulta);
					while ($valor = mysqli_fetch_array($consulta)) {
						//Damos la bienvenida al usuario.
						echo '<h2>Bienvenido '.utf8_encode($valor['Nombre_Usuario']).' '.utf8_encode($valor['Apellido1_Usuario']).' '.utf8_encode($valor['Apellido2_Usuario']).'</h2>';
					}
				}
			?>
			<form action="home.php?user=<?php echo "$user" ?>">
			<!-- action="home.php?user=<?php //echo "$user" ?> -->
		   	<select name="disponibilidad">    
		       <option value="" selected="selected">--Disponibilidad--</option>  
		       <option value="Si">Disponible</option>
		       <option value="No">No disponible</option>
		   	</select>
		   	<div>
		   	</br></br>	
		   	<select name="tiporecurso">
		   		<option value="" selected="selected">--Tipo de recurso--</option>    
		       	<option value="Aula">Aula</option>
		       	<option value="Aula con material informático">Aula con proyector</option>
		       	<option value="Material informático">Material informático</option>
		   	</select>
		   	</br></br></br></br>
		   	<input type="hidden" name="user" value="<?php echo "$user" ?>">
		   	<button type="submit" name="enviar" value="enviar ">Enviar</button>
		   	<button><a style='text-decoration:none;color:black;(otros)' <?php  echo "href='home.php?user=$user'" ?>>Resetear Valores</a></button></br></br>
		   	</form>  	
			<?php
			//Filtro
			$q=("SELECT * FROM tbl_recurso");
			$consulta=mysqli_query($conexion,$q);
			if (!isset($_REQUEST['enviar'])) {

				while ($valores = mysqli_fetch_array($consulta)) {
		          	echo '<form action="reservas.php" method="post">';
	    			echo '<div>Recurso: '.utf8_encode($valores['Nombre_Recurso']).'</br>';
					echo 'Descripción: '.utf8_encode($valores['Descripcion_Recurso']).'</br>';
					echo 'Tipo de recurso: '.utf8_encode($valores['Tipo_Recurso']).'</br>';
					echo 'Disponible: '.utf8_encode($valores['Disponibilidad_Recurso']). '</br>';
					echo 'Foto:<br/> <img width="300" src="../img/'.$valores['Fotos_Recurso'].'"></br>';
					echo "<input type='checkbox' name='reserva[]' value='$valores[Id_Recurso]'>Reservar</input></br></br></div>";
				}		  
					echo "</br></br><input type='submit' value='Realizar'/>";
		 			echo '</form>';	
		 			echo "<button><a style='text-decoration:none;color:black;(otros)' href='../index.php'>Salir sesión</a></button>"; 
				
			}else{

				$disponibilidad=$_REQUEST['disponibilidad'];
				$tiporecurso=$_REQUEST['tiporecurso'];
				$cont=false;
				$q=("SELECT * FROM tbl_recurso");
				if (isset($disponibilidad)) {
					$q.= " WHERE `Disponibilidad_Recurso` = '$disponibilidad'";
					$cont=true;

				}

				if (isset($tiporecurso) && $cont==false) {
					$q.= " WHERE `Tipo_Recurso` = '$tiporecurso'";
				}elseif (isset($tiporecurso) && $cont == true ) {
					$q.= " AND `Tipo_Recurso` = '$tiporecurso'";
				}


				//$filtro=" WHERE `Disponibilidad_Recurso` LIKE '$disponibilidad' AND `Tipo_Recurso`='$tiporecurso'";
				//$qfiltro=$q.$filtro;
				$consulta=mysqli_query($conexion,$qfiltro);
				echo $disponibilidad."</br>";
				echo $tiporecurso."</br>";
				echo $qfiltro."</br>";
				echo $consulta."</br>";

					while ($valores = mysqli_fetch_array($consulta)) {
		          	echo '<form action="reservas.php" method="post">';
	    			echo '<div>Recurso: '.utf8_encode($valores['Nombre_Recurso']).'</br>';
					echo 'Descripción: '.utf8_encode($valores['Descripcion_Recurso']).'</br>';
					echo 'Tipo de recurso: '.utf8_encode($valores['Tipo_Recurso']).'</br>';
					echo 'Disponible: '.utf8_encode($valores['Disponibilidad_Recurso']). '</br>';
					echo 'Foto:<br/> <img width="300" src="../img/'.$valores['Fotos_Recurso'].'"></br>';
					echo "<input type='checkbox' name='reserva[]' value='$valores[Id_Recurso]'>Reservar</input></br></br></div>";
				}		  
					echo "</br></br><input type='submit' value='Realizar'/>";
		 			echo '</form>';	
		 			echo "<button><a style='text-decoration:none;color:black;(otros)' href='../index.php'>Salir sesión</a></button>"; 

			}
	        
		?>
	</body>
</html>