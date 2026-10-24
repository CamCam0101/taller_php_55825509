<?php
class Calculadora
{
    private float $a;
    private float $b;

    function __construct(float $a, float $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    function sumar(): float
    {
        return $this->a + $this->b;
    }

    function restar(): float
    {
        return $this->a - $this->b;
    }

    function multiplicar(): float
    {
        return $this->a * $this->b;
    }

    // devuelve null si se intenta dividir entre cero
    function dividir(): ?float
    {
        if ($this->b == 0) {
            return null;
        }
        return $this->a / $this->b;
    }

    // "a % de b": por ejemplo 20 % de 150 = 30
    function porcentaje(): float
    {
        return ($this->a / 100) * $this->b;
    }
}