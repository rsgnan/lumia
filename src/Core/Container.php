<?php

namespace App\Core;

// Simples container de injeção de dependências
class Container
{
    private array $instances = [];
    private array $recipes = [];

    // Guarda a receita
    public function bind(string $what, \Closure $recipe)
    {
        $this->recipes[$what] = $recipe;
    }
    // Container simples para registro das receitas
    public function get($what)
    {
        if (empty($this->instances[$what])) {
            if (empty($this->recipes[$what])) {
                echo "Could not build: {$what}. \n";
                die();
            }
            $this->instances[$what] = $this->recipes[$what]();
        }
        return $this->instances[$what];
    }
}
