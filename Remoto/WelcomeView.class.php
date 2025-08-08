<?php
class WelcomeView extends TPage
{
    private $html;

    public function __construct()
    {
        parent::__construct();

        $this->html = new THtmlRenderer('app/resources/welcome.html');

        // Aqui você chama a API (pode ser local ou externa)
        $data = $this->fetchDataFromAPI();

        // Mostra JSON formatado em <pre>
        $json_pretty = '<pre>' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';

        $panel = new TPanelGroup('Resultado da API');
        $panel->add($json_pretty);

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($panel);

        parent::add($vbox);
    }

    private function fetchDataFromAPI()
        {
            try {
                $url = 'http://spdnetweb.sp1.br.saveincloud.net.br/API/rest.php?class=ApiReceita&method=onGet';
        
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
                $response = curl_exec($ch);
        
                if (curl_errno($ch)) {
                    throw new Exception(curl_error($ch));
                }
        
                curl_close($ch);
        
                return json_decode($response, true);
            } catch (Exception $e) {
                return ['erro' => $e->getMessage()];
            }
        }
}

