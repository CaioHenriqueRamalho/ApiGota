<?php
class ApiReceita
{
    /**
     * Endpoint GET
     * URL: rest.php?class=ApiReceita
     */
    public function onGet($param)
    {
        try {
            // Abre transação com o banco de dados (nome conforme application.ini)
            TTransaction::open('Netcfg');

            // Usa o repositório do ActiveRecord Receita
            $repo = new TRepository('TABCVALID');
            $criteria = new TCriteria;

            // Filtro opcional: ?id=1
            if (!empty($param['id'])) {
                $criteria->add(new TFilter('id', '=', $param['id']));
            }

            $receitas = $repo->load($criteria);

            $result = [];
            if ($receitas) {
                foreach ($receitas as $receita) {
                    $result[] = $receita->toArray();
                }
            }

            TTransaction::close();

            // Retorna JSON simples
            return $result;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}