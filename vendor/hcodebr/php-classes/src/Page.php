<?php

//especificar o namespace de onde a classe está
namespace Hcode;

//Usando classe de outro namespace/namespace próprio da classe
use Rain\Tpl;

class Page
{

    // Vai ser estrturado usando métodos mágicos, construct e destruct
    // O construct é chamado no ínicio da execução da página
    // O destruct no fim da execução


    private $tpl;
    private $options = []; // array que recebe o merge de $opts e defaults
    private $defaults = [ // opts defauts, que é uma array. E dentro temos uma elemento, que também é array
        "header"=> true,
        "footer"=>true,
        "data" => []
    ];
    public function __construct($opts = array(), $tpl_dir = "views/") // as variáveis que vão vir da rota, vem no construct
    {
        $this->options = array_merge($this->defaults, $opts); // ultimo sobrepoe o primeiro

        // config
        $config = array(
            "tpl_dir"       => $tpl_dir, // caminho de onde a pasta de arquivos será criada
            "cache_dir"     => "views-cache/", // caminho de onde a pasta de cache será criada
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure($config); // function do Tpl que recebe as config

        //Atributo da classe, $tpl, recebe a instancia de Tpl
        $this->tpl = new Tpl;

        

        $this->setData($this->options["data"]);

        

        // draw, método que vai montar o template. Recebe o arquivo a ser exibido
       if($this->options["header"] === true) $this->tpl->draw("header"); // arquivo exibido em todas as páginas. Criado dentro da pasta do template
    }

    /*
    * Sempre que começar a repetir o códgio, criar método
    * Método setData faz o foreach no array de dados 
    */
    private function setData($data = array())
    {
        foreach ($data as $key => $value) {
            //Método de Tpl que recebe as variáveis. As variáveis vão vir de acordo com a rota que for chamada no slim
            //o foreach percorre o array que tem as variáves e vai passando chave e valor pro tpl->assing 
            $this->tpl->assign($key, $value);
        }
    }



    // Método para o body
    public function setTpl($name, $data = array(), $returnHTML  = false)
    {
        $this->setData($data);
        $this->tpl->draw($name);
    }

    public function __destruct()
    {
        if($this->options["footer"] === true) $this->tpl->draw("footer"); // arquivo criado no fim da execução, exibido em todas as páginas. Criado dentro da pasta do template
    }
}
