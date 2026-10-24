<?php
class Nodo
{
    private string $valor;
    private ?Nodo $izq = null;
    private ?Nodo $der = null;

    function __construct(string $valor)
    {
        $this->valor = $valor;
    }

    function getValor(): string
    {
        return $this->valor;
    }

    function getIzq(): ?Nodo
    {
        return $this->izq;
    }

    function getDer(): ?Nodo
    {
        return $this->der;
    }

    function setIzq(?Nodo $nodo): void
    {
        $this->izq = $nodo;
    }

    function setDer(?Nodo $nodo): void
    {
        $this->der = $nodo;
    }
}