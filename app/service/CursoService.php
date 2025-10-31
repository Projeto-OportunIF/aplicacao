<?php

require_once(__DIR__ . "/../model/Curso.php");

class CursoService
{

    /* Método para validar os dados do curso que vem do formulário */
    public function validarDados(Curso $curso)
    {
        $erros = [];

        //Validar campos vazios
        if (! $curso->getNome())
            $erros['nome'] = "O campo Nome do Curso é obrigatório.";

        return $erros;
    }
}
