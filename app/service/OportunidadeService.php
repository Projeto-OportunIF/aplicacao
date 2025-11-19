<?php

require_once(__DIR__ . "/../model/Oportunidade.php");

class OportunidadeService
{
    /* Método para validar os dados da oportunidade que vêm do formulário */
    public function validarDados(Oportunidade $oportunidade): array
    {
        $erros = [];

        // Validação de campos obrigatórios
        if (!$oportunidade->getTitulo()) {
            $erros['titulo'] = "O campo Título é obrigatório.";
        }

        if (!$oportunidade->getDescricao()) {
            $erros['descricao'] = "O campo Descrição é obrigatório.";
        }

        if (!$oportunidade->getProfessor()) {
            $erros['profresponsavel'] = "O campo Professor Responsável é obrigatório.";
        }

        if (!$oportunidade->getTipoOportunidade()) {
            $erros['tipooport'] = "O campo Tipo de oportunidade é obrigatório.";
        }

        if (!$oportunidade->getDataInicio()) {
            $erros['datainicio'] = "O campo Data de Início é obrigatório.";
        }

        if (!$oportunidade->getDataFim()) {
            $erros['datafim'] = "O campo Data de Fim é obrigatório.";
        }

        if (!$oportunidade->getVaga()) {
            $erros['vaga'] = "O campo Quantidade de Vagas é obrigatório.";
        }

        if (!$oportunidade->getCurso()) {
            $erros['curso'] = "O campo Curso é obrigatório.";
        }

        // Validar se a data de início é anterior à data de fim
        if ($oportunidade->getDataInicio() && $oportunidade->getDataFim()) {
            $inicio = strtotime($oportunidade->getDataInicio());
            $fim = strtotime($oportunidade->getDataFim());

            if ($inicio > $fim) {
                $erros['data'] = "A Data de Início deve ser anterior à Data de Fim.";
            }
        }

        if ($oportunidade->getDocumentoEdital() === null) {
            // Nenhum arquivo enviado e nenhum documento existente
            $erros['documentoEdital'] = "O campo Documento Edital é obrigatório.";
        }

      

        // =======================
        // Validação do Documento Anexo
        // =======================
        $temDocumento = isset($_POST['temDocumento']) && $_POST['temDocumento'] == "1";
        if ($temDocumento && trim($oportunidade->getDocumentoAnexo()) === "") {
            $erros['documentoAnexo'] = "Você marcou que existe documento anexo, mas não informou a descrição do documento.";
        }

     

        return $erros;
    }
}
