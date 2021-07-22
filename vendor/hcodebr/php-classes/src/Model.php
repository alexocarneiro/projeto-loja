<?php  

namespace Hcode;


/**
 * Classe para fazer Get and Setters dinamicamente
 * Para isso funcionar, usamos o método mágico __call
 * Os valores dos atributos vão ficar em um array
 * O substr é para pegar informação se é get ou set e armazenar em $method
 * O substr é para pegar informação do nome do campo e armazenar em $fieldName
 * O método setData recupera todos os campos de um usuário que veio do banco e insere no array values
 */

class Model
{
    private $values = [];


    public function __call($name, $args)
    {
        //Descobrir se é get ou set
        $method = substr($name, 0, 3);

        //Descobrir o nome do campo
        $fieldName = substr($name, 3, strlen($name));

        //switch para aaplicar uma ação caso seja get ou outra ação caso seja set
        switch($method)
        {
            case "get":
                return $this->values[$fieldName];
            break;
            
            case "set":
                $this->values[$fieldName] = $args[0];
            break;    


        }



    }

    public function setData($array = array()){
        foreach($array as $key => $values){
            $this->{"set".$key}($values);
        }
    }

    public function getData()
    {
        return $this->values;
    }

    
}


?>