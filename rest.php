<?php
// Arquivo: rest.php


header('Content-Type: application/json; charset=utf-8');

// Carrega o bootstrap da aplicação (ajuste o caminho conforme necessário)
require_once 'init.php'; // ou 'lib/adianti/AdiantiLoader.php' dependendo do projeto

/**
 * Classe para lidar com chamadas REST
 */
class AdiantiRestServer
{
    public static function run($request)
    {
        // Carrega configurações da aplicação
        $ini = AdiantiApplicationConfig::get();

        // Captura dados JSON do corpo da requisição (para POST, PUT, etc.)
        $input = json_decode(file_get_contents("php://input"), true);

        // Junta dados da URL (GET) com dados do corpo (POST/PUT)
        $request = array_merge($request, (array) $input);

        // Pega os parâmetros obrigatórios
        $class  = isset($request['class'])  ? $request['class']  : '';
        $method = isset($request['method']) ? $request['method'] : ''; // opcional

        try {
            // Executa a classe da API (ex: ApiReceita)
            $response = AdiantiCoreApplication::execute($class, $method, $request, 'rest');

            // Retorna JSON com sucesso
            return json_encode([
                'status' => 'success',
                'data'   => $response
            ]);
        } catch (Exception $e) {
            // Retorna erro como JSON
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}

// Executa o servidor REST com os parâmetros da requisição
echo AdiantiRestServer::run($_REQUEST);