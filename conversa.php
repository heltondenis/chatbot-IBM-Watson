
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Garantir que seja lido sem problemas
header("Content-Type: text/plain");

//Worskspace
$workspace = "Digite o ID do seu Workspace";

//Dados de Login
$username = "Seu usuário da API";
$password = "Sua senha da API";

//Capturar Texto
//Use $_POST em produção, por segurança
$texto = $_REQUEST["texto"];

//Verifica se existe identificador
//Caso não haja, crie um
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION["identificador"])){
	$identificador = $_SESSION["identificador"];
}else{
	//Você pode usar qualquer identificador
	//Você pode usar ID do usuário ou similar
	$identificador = md5(uniqid(rand(), true));
	$_SESSION["identificador"] = $identificador;
}

//URL da API
//(deve ser passado o método e a versão da API em GET)
$url = "https://gateway.watsonplatform.net/assistant/api/v1/workspaces/" . $workspace;
$urlMessage = $url . "/message?version=2018-02-16";

//Dados
$dados  = "{";
$dados .= "\"input\": ";
$dados .= "{\"text\": \"" . $texto . "\"},";
$dados .= "\"context\": {\"conversation_id\": \"" . $identificador . "\",";
$dados .= "\"system\": {\"dialog_stack\":[{\"dialog_node\":\"root\"}], \"dialog_turn_counter\": 1, \"dialog_request_counter\": 1}}";
$dados .= "}";

//Cabeçalho que leva tipo de Dados
$headers = array('Content-Type:application/json');

//Iniciando Comunicação cURL
$ch = curl_init();
//Selecionando URL
curl_setopt($ch, CURLOPT_URL, $urlMessage);
//O cabeçalho é importante para definir tipo de arquivo enviado
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//Habilitar método POST
curl_setopt($ch, CURLOPT_POST, 1);
//Enviar os dados
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
//Capturar Retorno
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Autenticação
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//Executar
$retorno = curl_exec($ch);
//Fechar Conexão
curl_close($ch);

//Imprimir com leitura fácil para humanos
$retorno = json_decode($retorno);
echo json_encode($retorno, JSON_PRETTY_PRINT);

?>
