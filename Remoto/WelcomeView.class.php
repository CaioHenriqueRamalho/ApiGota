<?php
class WelcomeView extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        // Formulário (BootstrapFormBuilder é opcional, use TForm se não tiver)
        $this->form = new BootstrapFormBuilder('form_api');
        $this->form->setFormTitle('Consultar Receituario');

        $idsenha = new TEntry('IDSENHA');
        $idsenha->setSize('50%');

        $this->form->addFields([new TLabel('IDSENHA')], [$idsenha]);

        // Botão chama método onSearch (instance method)
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);

        parent::add($container);
    }

    /**
     * Método chamado pelo botão
     * $param virá com ['IDSENHA' => '...']
     */
    public function onSearch($param)
    {
        try
          {
             if(empty($param['IDSENHA'])) 
               {
                  throw new Exception('Informe o campo IDSENHA.');
               }

              // Ajuste a URL conforme seu projeto
             $url = 'http://spdnetweb.sp1.br.saveincloud.net.br/Api/rest.php?class=ApiReceita&method=onPost';
          

             $payload = json_encode(['IDSENHA' => $param['IDSENHA']]);

             $ch = curl_init($url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
             curl_setopt($ch, CURLOPT_HTTPHEADER, [
                 'Content-Type: application/json',
                 'Accept: application/json'
                 ]);
             curl_setopt($ch, CURLOPT_TIMEOUT, 10);

             $response = curl_exec($ch);
             if(curl_errno($ch)) 
               {
                 throw new Exception('cURL error: ' . curl_error($ch));
               }
             curl_close($ch);

             $data = json_decode($response, true);
             if($data === null && json_last_error() !== JSON_ERROR_NONE) 
               {
                 throw new Exception('Resposta inválida JSON: ' . json_last_error_msg());
               }

             // Se seu rest.php usa o formato {status:..., data:...}
             if(isset($data['status']) && $data['status'] === 'error') 
               {
                  $msg = isset($data['message']) ? $data['message'] : json_encode($data);
                  throw new Exception('Erro da API: ' . $msg);
               }

             $payload_to_show = isset($data['data']) ? $data['data'] : $data;

             // Mostra resultado em modal (formatado)
             $pretty = '<pre>' . json_encode($payload_to_show, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';

             $panel = new TPanelGroup('Resultado da API');
             $panel->add($pretty);
        
             $vbox = new TVBox;
             $vbox->style = 'width: 100%';
             $vbox->add($panel);
             parent::add($vbox);

        

         }
       catch (Exception $e) 
         {
             new TMessage('error', $e->getMessage());
         }
    }
}