<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();
	$page->setTpl("index");

});

$app->get('/admin', function(){

	//Método estático para validar o login
	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("index");

});


/**
 * A página de login não tem o header e o footer. 
 * Para desabilitar eles pode-se passar essa informação no parâmetro do construct
 * O construct pode receber um array de opções, que é depois é mesclado com o array defaults da classe
 * É necessário criar opções padrões no array defaults
 */
$app->get('/admin/login', function(){
	// cria uma nova instancia de PageAdmin para usar o setTpl para montar o template de login
	// o new é em PageAdmin, porque o login é de admin e não do site.
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("login");


});

/**
 * Rota para vlidar o login
 * Método estático da classe User que vai receber os parêmetros de login e senha
 * método header com parâmetro location para fazer o redirecet
 */
$app->post('/admin/login', function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;
});

$app->get('/admin/logout', function(){
	
	User::logout();
	header("Location: /admin/login");
	exit;
	
});

$app->run();

 ?>