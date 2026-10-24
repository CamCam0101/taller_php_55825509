<?php
class Conjuntos
{
    private array $a;
    private array $b;

    function __construct(array $a, array $b)
    {
        // un conjunto no tiene elementos repetidos
        $this->a = array_values(array_unique($a));
        $this->b = array_values(array_unique($b));
    }

    function getA(): array
    {
        return $this->a;
    }

    function getB(): array
    {
        return $this->b;
    }

    function getUnion(): array
    {
        $union = array_unique(array_merge($this->a, $this->b));
        sort($union);
        return $union;
    }

    function getInterseccion(): array
    {
        $inter = array_intersect($this->a, $this->b);
        sort($inter);
        return $inter;
    }

    // elementos de A que NO están en B
    function getDiferenciaAB(): array
    {
        $dif = array_diff($this->a, $this->b);
        sort($dif);
        return $dif;
    }

    // elementos de B que NO están en A
    function getDiferenciaBA(): array
    {
        $dif = array_diff($this->b, $this->a);
        sort($dif);
        return $dif;
    }
}