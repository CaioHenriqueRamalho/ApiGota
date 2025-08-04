<?php
class LoginAdmin extends TWindow
  {
      private $form;
      
      public function __construct()
        {
           parent::__construct();
           parent::setSize(0.5, null);
           parent::removePadding();
           parent::removeTitleBar();
           parent::disableEscape();

           $this->form = new BootstrapFormBuilder();
           $this->form->setFormTitle('Validacao Admin');

           $id  = new TEntry('IDADMIN');
           $id->setSize('50%');
           $id->style = 'margin-left: 30px;';
           
           $id->addValidation('IDADMIN', new TRequiredValidator);
           
           $this->form->addFields([new TLabel('Informe seu codigo')], [$id]);
           
           $btn_enviar = $this->form->addAction('Acessar', new TAction([$this, 'onEnviar']), 'fas:door-open fa-fw black ');
           $btn_enviar->style = 'width: 200px; height: 40px;margin: 0 auto; display: block;';
           
           parent::add($this->form);
        }
     public function onEnviar($param)
        {
            try
              {
                  $this->form->validate();
                  $data = $this->form->getData();
                  
                  TTransaction::open('Netcfg');
              
                  $conn = TTransaction::get();

                  $sql = "SELECT IDADMIN FROM TABWROT WHERE IDADMIN = :admin ";
                  $stmt = $conn->prepare($sql);
                  $stmt->bindValue(':admin', $data->IDADMIN);

                  $stmt->execute();
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  if($result)
                    {
                       TApplication::loadPage('Grafico');
                    }
                  else
                    {
                        new TMessage('warning', 'Codigo incorreto');
                        TApplication::loadPage('WelcomeView');
                    }               
                  
              }
            catch(Exception $e)
              {
                 new TMessage('error', $e->getMessage());
              }
        }

  }
