<?php
class ProtocoloForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        // Cria o formulário
        $this->form = new BootstrapFormBuilder('form_protocolo');
        $this->form->setFormTitle('Gerar Protocolo');

        // Campo de entrada
        $nome = new TEntry('nome');
        $nome->setSize('100%');

        // Adiciona ao formulário
        $this->form->addFields([new TLabel('Nome')], [$nome]);

        // Botão de envio
        $btn = $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:check green');

        // Exibe o formulário
        parent::add($this->form);
    }

    public static function gerarNumeroProtocolo()
    {
        $data = date('Ymd'); // Ex: 20250604

        // Aqui pode usar banco, mas neste exemplo apenas simula
        $contador = rand(1, 9999); // ou use contador real do BD
        $numeroFormatado = str_pad($contador, 4, '0', STR_PAD_LEFT);

        return "PROTO-{$data}-{$numeroFormatado}";
    }

    public function onSend($param)
    {
        try {
            TTransaction::open('seu_banco'); // Use o nome correto da conexão

            $data = $this->form->getData();
            $this->form->validate(); // Validação básica se necessário

            $protocolo = self::gerarNumeroProtocolo();

            // Aqui você pode salvar em uma tabela, se quiser
            // Por simplicidade, vamos apenas mostrar o protocolo

            new TMessage('info', "Protocolo gerado: <b>$protocolo</b><br>Nome: <b>{$data->nome}</b>");

            TTransaction::close();

            $this->form->setData($data); // mantém os dados no form
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}
