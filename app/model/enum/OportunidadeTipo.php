<?php
# Nome do arquivo: OportunidadeTipo.php
# Objetivo: classe Enum para os tipos de oportunidade

class OportunidadeTipo
{
    public static string $SEPARADOR = "|";

    const ESTAGIO = "ESTAGIO";
    const PROJETOEXTENSAO = "PROJETOEXTENSAO";
    const PROJETOPESQUISA = "PROJETOPESQUISA";

    public static function getAllAsArray()
    {
        return [
            OportunidadeTipo::ESTAGIO,
            OportunidadeTipo::PROJETOEXTENSAO,
            OportunidadeTipo::PROJETOPESQUISA
        ];
    }
    // Retorna um nome mais "bonito" para o tipo
    public static function getLabel($tipo)
    {
        switch ($tipo) {
            case self::ESTAGIO:
                return "Estágio";
            case self::PROJETOEXTENSAO:
                return "Projeto de Extensão";
            case self::PROJETOPESQUISA:
                return "Projeto de Pesquisa";
            default:
                return $tipo;
        }
    }
}
