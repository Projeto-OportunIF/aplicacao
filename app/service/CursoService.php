<?php

require_once(__DIR__ . "/../model/Curso.php");

class CursoService
{

    /* Método para validar os dados do curso que vem do formulário */
    public function validarDados(Curso $curso)
    {
        $erros = array();

        //Validar campos vazios
        if (! $curso->getNome())
            array_push($erros, "O campo [Nome ] é obrigatório.");

        return $erros;
    }
}
