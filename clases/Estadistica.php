<?php
class Estadistica
{
    private array $numeros;

    function __construct(array $numeros)
    {
        $this->numeros = $numeros;
    }

    function getPromedio(): float
    {
        return array_sum($this->numeros) / count($this->numeros);
    }

    function getMediana(): float
    {
        $ordenados = $this->numeros;
        sort($ordenados);
        $n = count($ordenados);
        $mitad = intdiv($n, 2);

        if ($n % 2 == 0) {
            // cantidad par: promedio de los dos centrales
            return ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2;
        }
        // cantidad impar: el del centro
        return $ordenados[$mitad];
    }

    // Devuelve un arreglo, porque puede haber varias modas o ninguna
    function getModa(): array
    {
        $textos = array_map('strval', $this->numeros);
        $conteo = array_count_values($textos);
        $maximo = max($conteo);

        if ($maximo == 1) {
            return []; // ningún número se repite
        }

        $moda = [];
        foreach ($conteo as $valor => $veces) {
            if ($veces == $maximo) {
                $moda[] = (float) $valor;
            }
        }
        return $moda;
    }
}