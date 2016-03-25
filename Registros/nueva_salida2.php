<?php
session_start();
    $usuario = $_SESSION['s_username'];
    if(!isset($usuario)){
        header("Location: ../res.php");
    }
?>
<?php require '../conectar.php'; ?>
<?php require '../info.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INCES</title>

<link href="../css/menu.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="principal">

  <div id="cabecera"> 
    <div id="titulo"> 
      <div id="logout">
        <?php 
        echo "Bienvenido <b>".$_SESSION['s_username']."</b> "; 
        ?>
      </div>
    </div>
  </div>
  
<div id="menu">
<ul>
   <li><a href="/Compu-Soft/index.php">Inicio</a> 
    </li>
    <li><a href="#">Registro</a> 
      <ul>
    <li><a href="/Compu-Soft/Registros/nuevo_ingreso.php">Ingreso De Articulos</a></li>
    <li><a href="/Compu-Soft/Registros/nueva_salida.php">Salida De Articulos</a></li>
    <li><a href="/Compu-Soft/Buscar/buscar_art.php">Buscar Articulos</a></li>
        </ul>
    </li>
  <li><a href="#">Reportes</a> 
      <ul>
      <li><a href="/Compu-Soft/Movimientos/movimiento_compu2.php">Inventario General</a></li>
      <li><a href="/Compu-Soft/Movimientos/movimiento_entrada.php">Entrada</a></li>
      <li><a href="/Compu-Soft/Movimientos/movimiento_salida.php">Salida</a></li>
       </ul>
    </li>
  <li><a href="#">Configuracion</a> 
      <ul>
        <li><a href="/Compu-Soft/Registros/r_articulos.php">Nuevo Articulo</a></li> 
        <li><a href="/Compu-Soft/Registros/tipo.php">Nuevo Tipo</a></li>
        <li><a href="/Compu-Soft/Borrar/borrar_tipo.php">Borrar Tipo</a></li>
        <li><a href="/Compu-Soft/Borrar/borrar_movimiento.php">Borrar Movimientos</a></li>
        <li><a href="/Compu-Soft/Borrar/borrar_art.php">Borrar Articulos</a></li>
        <li><a href="/Compu-Soft/Backup/backup.php">Copia de Seguridad</a></li>
        </ul>
    </li>
  <li><a href="/Compu-Soft/creditos.php">Acerca De</a> 
    </li>


    </li>
    <li><a href="/Compu-Soft/logout.php" onclick="if(confirm('&iquest;Esta seguro que desea cerrar la sesi&oacute;n?')) return true;  else return false;" >Salir</a>  
    </li>
    </ul>
</div>
</div> <!-- fin menu -->
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php

// declarando las variables provenientes desde nuevo_ingreso.php
$tipo_m = $_POST['modelo']; //
$tipo = $_POST['tipo'];  //tipo de movimiento =  salida
//$marca = $_POST['marca'];
//$modelo = $_POST['modelo'];
$qty = $_POST['qty'];  //unidades de articulos
$fecha = $_POST['fecha'];
$compu_cli = $_POST['cli'];
$observacion = $_POST['des']; 
//para actualizar en la tabla ciente
$descripcion = $_POST['marca'];

// $ini es un contador, iniciado en cero, inserta los datos ingresados en mov_ingreso.php hasta que sea igual al numero de cantidades.
$ini = 0 ;

  //$tipo = $tipo[$ini];
	//$marca = $marca[$ini];
	$tipo = ucwords($tipo);
	$qty = $qty[$ini];
	$fecha = $fecha[$ini];
	$compu_cli = ucwords($compu_cli[$ini]);//Primera Letra de cada palabra en Mayusculas
	$observacion = ucwords($observacion[$ini]);//Primera Letra de cada palabra en Mayusculas
	$descripcion = ucwords($descripcion[$ini]);

$sql_insert = "INSERT INTO reporte (tipo_m, compu_tipo, compu_unidades, compu_fecha, compu_cli, compu_des, compu_observacion) VALUES ( '$tipo', '$tipo_m', '$qty', '$fecha', '$compu_cli', '$observacion', '$descripcion')";

$sql_qty = "UPDATE registro SET unidades = unidades - '$qty' WHERE tipo in(SELECT nombre_tipo FROM configuracion where id_tipo = '$tipo_m') AND descripcion =  '$descripcion'";
//modificara donde este el mismo tipo y descripcion
//echo $sql_insert.'<br>ff';	
//echo $sql_qty;

	mysql_query($sql_insert) or die(mysql_error(). " Query: " . $sql_insert);
	mysql_query($sql_qty) or die(mysql_error(). " Query: " . $sql_qty);

//mensaje para verificar
 //if verifico echo
  

	$ini++ ;

	print ("<script>alert('La operacion ha resultado satisfactoria');</script>");
 print('<meta http-equiv="refresh" content="0; URL=../Registros/nueva_salida.php">');
    
  //echo '<div align="center">Lo operacion ha resultado satisfactoria</div>';

?>
</body>
</html>
