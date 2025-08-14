<?php
class ApiReceita
{
    public function onPost($param)
    {
        try 
          {
              header('Content-Type: application/json; charset=utf-8');
              TTransaction::open('Netcfg');

              $repo = new TRepository('TABCVALID');
              $criteria = new TCriteria;

              // Verifica se pelo menos um parâmetro foi informado
              $hasCriteria = false;

              if(!empty($param['IDLIVRE'] and $param['IDCNPJ'])) 
                {
                    $criteria->add(new TFilter('IDLIVRE', '=', $param['IDLIVRE']));
                    $criteria->add(new TFilter('IDCNPJ', '=', $param['IDCNPJ']));
                    $hasCriteria = true;
                }
              
              //Bloqueia se não enviou nenhum parâmetro  
              if(!$hasCriteria) 
                {
                    TTransaction::close();
                    http_response_code(400);
                    echo json_encode([
                        'permissao'  => '0',
                        'message' => 'É necessário informar IDSENHA ou IDCNPJ para consultar'
                    ], JSON_UNESCAPED_UNICODE);
                     return;
                }

              $receitas = $repo->load($criteria);

              // Se não encontrou registros, retorna erro
              if(!$receitas) 
                {
                    TTransaction::close();
                    http_response_code(404);
                    return [
                        'permissao'  => '0',
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
                  'permissao' => '1',
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
