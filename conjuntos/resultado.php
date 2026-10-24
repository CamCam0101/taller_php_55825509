<?php
include "../clases/Conjuntos.php";

// Convierte "1, 2, 3" en [1, 2, 3]. Devuelve null si algún dato no es entero.
function convertir(string $texto): ?array
{
    $partes = preg_split('/[\s,;]+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    $numeros = [];

    foreach ($partes as $parte) {
        if (!preg_match('/^-?\d+$/', $parte)) {
            return null;
        }
        $numeros[] = (int) $parte;
    }

    if (count($numeros) == 0) {
        return null;
    }
    return $numeros;
}

// Muestra un conjunto como {1, 2, 3}
function mostrar(array $conjunto): string
{
    if (count($conjunto) == 0) {
        return "{ } (conjunto vacío)";
    }
    return "{" . implode(", ", $conjunto) . "}";
}

if (!isset($_POST['conjuntoA']) || !isset($_POST['conjuntoB'])) {
    header("Location: index.html");
    exit;
}

$a = convertir($_POST['conjuntoA']);
$b = convertir($_POST['conjuntoB']);
$error = ($a === null || $b === null);

if (!$error) {
    $conjuntos = new Conjuntos($a, $b);
}
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
    <a href="index.html">Calcular otro</a>
    <a href="../index.html">Volver al Menú principal</a>
    <br><br>
    <?php if ($error): ?>
        <p>Error: ingrese solo números enteros separados por comas, en ambos conjuntos.</p>
    <?php else: ?>
        <p>A = <?php echo mostrar($conjuntos->getA()); ?></p>
        <p>B = <?php echo mostrar($conjuntos->getB()); ?></p>
        <p class="green">A ∪ B (unión) = <?php echo mostrar($conjuntos->getUnion()); ?></p>
        <p class="green">A ∩ B (intersección) = <?php echo mostrar($conjuntos->getInterseccion()); ?></p>
        <p class="green">A - B = <?php echo mostrar($conjuntos->getDiferenciaAB()); ?></p>
        <p class="green">B - A = <?php echo mostrar($conjuntos->getDiferenciaBA()); ?></p>
    <?php endif; ?>
</body>

</html>