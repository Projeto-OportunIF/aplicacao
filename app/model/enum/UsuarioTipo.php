<?php
#Nome do arquivo: UsuarioPapel.php
#Objetivo: classe Enum para os papeis de permissões do model de Usuario

class UsuarioTipo {

    public static string $SEPARADOR = "|";

    const ALUNO =  "ALUNO";
    const ADMINISTRADOR = "ADMIN";
    const PROFESSOR = "PROFESSOR";
   
    public static function getAllAsArray() {
        return [UsuarioTipo::ALUNO, UsuarioTipo::PROFESSOR];
    }

}

