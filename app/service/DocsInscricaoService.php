<?php

class InscricaoService
{
    // Valida os dados da inscrição
    public function validarDados(array $dados): array
    {
        $erros = [];

        // Documento obrigatório
        if (empty($dados['documento'])) {
            $erros[] = "O envio do documento é obrigatório para realizar a inscrição.";
        }

        return $erros;
    }
}
