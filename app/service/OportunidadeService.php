<?php


require_once(__DIR__ . "/../model/Oportunidade.php");


class OportunidadeService
{
    /* Método para validar os dados da oportunidade que vêm do formulário */
    public function validarDados(Oportunidade $oportunidade): array
    {
        $erros = array();


        // Validar campos obrigatórios
        if (!$oportunidade->getTitulo())
            array_push($erros, "O campo [Título] é obrigatório.");


        if (!$oportunidade->getDescricao())
            array_push($erros, "O campo [Descrição] é obrigatório.");


        if (!$oportunidade->getTipoOportunidade())
            array_push($erros, "O campo [Tipo de oportunidade] é obrigatório.");


        if (!$oportunidade->getDataInicio())
            array_push($erros, "O campo [Data de Início] é obrigatório.");


        if (!$oportunidade->getDataFim())
            array_push($erros, "O campo [Data de Fim] é obrigatório.");


         if (!$oportunidade->getVaga())
            array_push($erros, "O campo [Vaga] é obrigatório.");


        if (!$oportunidade->getCurso())
            array_push($erros, "O campo [Curso] é obrigatório.");


       


        // Validar se a data de início é menor que a de fim
        if ($oportunidade->getDataInicio() && $oportunidade->getDataFim()) {
            $inicio = strtotime($oportunidade->getDataInicio());
            $fim = strtotime($oportunidade->getDataFim());


            if ($inicio > $fim)
                array_push($erros, "A [Data de Início] deve ser anterior à [Data de Fim].");
        }


        return $erros;
    }
}
