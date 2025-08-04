<?php
class TABCVALID extends TRecord
{
      const TABLENAME = 'TABCVALID';
      const PRIMARYKEY = 'ID';
      const IDPOLICY = 'max';
      
      public function __construct($ID = null, $callObjectLoad = true)
         {
            parent::__construct($ID, $callObjectLoad);
            
            parent::addAttribute('ID');
            parent::addAttribute('IDCNPJ');
            parent::addAttribute('IDSENHA');
            parent::addAttribute('IDUSUAR');
            parent::addAttribute('IDN1');
            parent::addAttribute('IDN2');
            parent::addAttribute('IDN3');
            parent::addAttribute('IDN4');
            parent::addAttribute('IDESP');
            parent::addAttribute('CRF');
            parent::addAttribute('IDLIVRE');
            
            
            
            

         }
}