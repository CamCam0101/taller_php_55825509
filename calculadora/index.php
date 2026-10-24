<?php
session_start();
$historial = $_SESSION['historial'] ?? [];
$ultimo = $_SESSION['ultimo'] ?? "";
$error = $_SESSION['error'] ?? "";
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Calculadora</h1>
    <a href="../index.html">Volver al menú</a>
    <br><br>

    <?php if ($error != ""): ?>
        <p class="error"><strong>Error:</strong> <?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($ultimo != ""): ?>
        <p class="resultado"><?php echo $ultimo; ?></p>
    <?php endif; ?>

    <form action="procesar.php" method="post">
        <label for="n1ID">Primer número:</label>
        <input type="number" step="any" name="numero1" id="n1ID" required>
        <br><br>
        <label for="opID">Operación:</label>
        <select name="operacion" id="opID" required>
            <option value="suma">Suma (+)</option>
            <option value="resta">Resta (-)</option>
            <option value="multiplicacion">Multiplicación (×)</option>
            <option value="division">División (÷)</option>
            <option value="porcentaje">Porcentaje (% de)</option>
        </select>
        <br><br>
        <label for="n2ID">Segundo número:</label>
        <input type="number" step="any" name="numero2" id="n2ID" required>
        <br><br>
        <button type="submit">Calcular</button>
    </form>

    <h2>Historial</h2>
    <?php if (count($historial) == 0): ?>
        <p>Aún no hay operaciones.</p>
    <?php else: ?>
        <ol>
            <?php foreach ($historial as $operacion): ?>
                <li><?php echo $operacion; ?></li>
            <?php endforeach; ?>
        </ol>
        <form action="borrar.php" method="post">
            <button type="submit">Borrar historial</button>
        </form>
    <?php endif; ?>
</body>

</html>