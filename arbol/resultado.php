<?php
include "../clases/ArbolBinario.php";

// Convierte "A → B → D" o "A, B, D" en ["A", "B", "D"]
function leer(string $texto): array
{
    return preg_split('/[\s,;→>-]+/u', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
}

if (!isset($_POST['preorden']) || !isset($_POST['inorden']) || !isset($_POST['postorden'])) {
    header("Location: index.html");
    exit;
}

$pre = leer($_POST['preorden']);
$in = leer($_POST['inorden']);
$post = leer($_POST['postorden']);

$arbol = new ArbolBinario($pre, $in, $post);
$error = $arbol->getError();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Resultado</h1>
    <a href="index.html">Construir otro</a>
    <a href="../index.html">Volver al Menú principal</a>
    <br><br>
    <?php if ($error != ""): ?>
        <p>Error: <?php echo $error; ?></p>
    <?php else: ?>
        <p>Árbol construido con: <strong><?php echo $arbol->getMetodo(); ?></strong></p>
        <div style="overflow-x: auto;"><?php echo $arbol->getSVG(); ?></div>
        <p>Preorden: <?php echo implode(" → ", $arbol->getRecorrido("preorden")); ?></p>
        <p>Inorden: <?php echo implode(" → ", $arbol->getRecorrido("inorden")); ?></p>
        <p>Postorden: <?php echo implode(" → ", $arbol->getRecorrido("postorden")); ?></p>
    <?php endif; ?>
</body>

</html>