<?php
# Nome do arquivo: StatusTipo.php
# Objetivo: Enum para os status de inscrição

class StatusTipo
{
    const PENDENTE = 'PENDENTE';
    const APROVADO = 'APROVADO';
    const REPROVADO = 'REPROVADO';

    // Retorna todos os status em um array
    public static function getAll(): array
    {
        return [
            self::PENDENTE,
            self::APROVADO,
            self::REPROVADO
        ];
    }

    // Retorna um label amigável para cada status (opcional)
    public static function getLabel(string $status): string
    {
        switch ($status) {
            case self::PENDENTE:
                return 'Pendente';
            case self::APROVADO:
                return 'Aprovado';
            case self::REPROVADO:
                return 'Reprovado';
            default:
                return 'Desconhecido';
        }
    }
}
