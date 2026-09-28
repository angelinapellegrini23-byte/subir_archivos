<?php

if (!isset($_FILES["archivo"])) {
    header("Location: index.html?error=No se seleccionó ningún archivo.");
    exit;
}

if ($_FILES["archivo"]["error"] != 0) {
    header("Location: index.html?error=Hubo un problema al subir el archivo.");
    exit;
}

$nombre = $_FILES["archivo"]["name"];
$temporal = $_FILES["archivo"]["tmp_name"];
$tamano = $_FILES["archivo"]["size"];

$extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

$permitidos = array("jpg", "jpeg", "png", "pdf");

if (!in_array($extension, $permitidos)) {
    header("Location: index.html?error=Tipo de archivo no permitido.");
    exit;
}

if ($tamano > 5 * 1024 * 1024) {
    header("Location: index.html?error=El archivo supera los 5 MB.");
    exit;
}


// Crear la carpeta si no existe

$carpeta = __DIR__ . "/archivos/";

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}


// Crear un nombre único

$nombreNuevo = uniqid() . "_" . basename($nombre);

$ruta = $carpeta . $nombreNuevo;


// Guardar archivo

if (move_uploaded_file($temporal, $ruta)) {

    header("Location: index.html?exito=¡Archivo subido con éxito!");

} else {

    header("Location: index.html?error=No se pudo guardar el archivo.");
}

exit;

?>