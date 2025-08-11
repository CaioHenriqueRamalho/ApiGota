<?php
class ApiReceita
{
    public function onPost($param)
    {
        try {
            TTransaction::open('Netcfg');

            $repo = new TRepository('TABCVALID');
            $criteria = new TCriteria;

            if (!empty($param['IDSENHA'])) {
                $criteria->add(new TFilter('IDSENHA', '=', $param['IDSENHA']));
            }

            $receitas = $repo->load($criteria);

            $result = [];
            if ($receitas) {
                foreach ($receitas as $receita) {
                    $result[] = $receita->toArray();
                }
            }

            TTransaction::close();

            return $result;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}