<?php
class WelcomeView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';

        $panel = new TPanelGroup('Resultado JSON da API');

        try {
            // Captura o conteúdo gerado pela classe ApiConsulta
            ob_start(); // Inicia o buffer
            new ApiReceitas(); // Executa a classe (que faz echo do JSON e dá exit)
            $json = ob_get_clean(); // Pega o conteúdo gerado antes do exit()

            // Decodifica e formata
            $dados = json_decode($json, true);
            $resultado = "<pre>" . print_r($dados, true) . "</pre>";
        } catch (Exception $e) {
            $resultado = 'Erro ao consultar API: ' . $e->getMessage();
        }

        $panel->add(new TLabel($resultado));
        $vbox->add($panel);

        parent::add($vbox);
    }
}