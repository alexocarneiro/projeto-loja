<?php  

/**
 * Como vamos usar herança, alguns ajustes serão necessários para o funcionamento corretod
 * do Rain/Tpl, na classe page o diretório do template é definido de forma estatíca, e isso vai
 * gerar conflito quando extendermos e criarmos o diretório templates para o PageAdmin. Então vamos passar o 
 * nome do diretório no parâmentro do construct
 */

// A classe PageAdmin é praticamente igual a classe Page, podendod ter alguns métodos diferentes,
// neste caso podemo usar a herança para essa classe.

//Informar o namespace
namespace Hcode;

class PageAdmin extends Page{

public function __construct($opts = array(), $tpl_dir = "views/admin/")
{
    /**
     * Usando herança, chamamos o método parent, e através dele o construct da classe page, e aí passamos
     * o $opts e $tpl_dir da classe PageAdmin, e o construct que já tem toda a lógica é executado com os
     * novos parâmetros.
     */
    parent::__construct($opts, $tpl_dir);


}




}



?>