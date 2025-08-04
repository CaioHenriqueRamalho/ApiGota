<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Database\TRepository;
use Adianti\Database\TCriteria;

class ApiReceitas extends TPage
{
    public function __construct()
    {
        try {
            TTransaction::open('Netcfg'); 
            
            $repo = new TRepository('TABCVALID'); 
            $criteria = new TCriteria;

            $objects = $repo->load($criteria);
            $data = [];

            foreach ($objects as $obj) {
                $data[] = $obj->toArray();
            }

            TTransaction::close();

            // Cabeçalho indicando que o retorno é JSON
            header('Content-Type: application/json');

            // Enviar resposta JSON e ENCERRAR execução
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            

        } catch (Exception $e) {
            TTransaction::rollback();

            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}