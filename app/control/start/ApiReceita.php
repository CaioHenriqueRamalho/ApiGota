<?php
class ApiReceita
{
    public function onPost($param)
    {
        try 
          {
              TTransaction::open('Netcfg');

              $repo = new TRepository('TABCVALID');
              $criteria = new TCriteria;

              // Verifica se pelo menos um parâmetro foi informado
              $hasCriteria = false;

              if(!empty($param['IDSENHA'])) 
                {
                    $criteria->add(new TFilter('IDSENHA', '=', $param['IDSENHA']));
                    $hasCriteria = true;
                }
              if(!empty($param['IDCNPJ'])) 
                {
                    $criteria->add(new TFilter('IDCNPJ', '=', $param['IDCNPJ']));
                    $hasCriteria = true;
                }

              $receitas = $repo->load($criteria);

              // Se não encontrou registros, retorna erro
              if(!$receitas) 
                {
                    TTransaction::close();
                    http_response_code(404);
                    return [
                        'status'  => 'error',
                        'message' => 'Usuário não localizado'
                    ];
                }

             // Monta resultado
             $result = [];
             foreach($receitas as $receita) 
                    {
                       $result[] = $receita->toArray();
                    }

             TTransaction::close();
             http_response_code(200);
             return [
                  'status' => 'success',
                  'data'   => $result
             ];
          } 
        catch (Exception $e) 
          {
             TTransaction::rollback();
             http_response_code(500);
             return [
                'status'  => 'error',
                 'message' => $e->getMessage()
             ];
          }
    }
}
