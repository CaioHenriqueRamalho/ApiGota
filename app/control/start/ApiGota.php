<?php
use Adianti\Control\TPage;
use Adianti\Control\TAction;
use Adianti\Database\TTransaction;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TFilter;

class ApiGota extends TPage
{
    public function onGetData($param = null)
    {
        try {
            TTransaction::open('Netcfg'); 

            $repo = new TRepository('TABCVALID'); 
            $criteria = new TCriteria;

            

            $objects = $repo->load($criteria);
            $result = [];

            if ($objects) {
                foreach ($objects as $obj) {
                    $result[] = $obj->toArray();
                }
            }

            TTransaction::close();

            // Exibe JSON direto na tela
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}