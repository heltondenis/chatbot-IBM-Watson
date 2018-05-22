

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
	.watson{
		border: 1px solid #B0BEC5;
		border-radius: 3px;
		height: 50em;
		max-height: 500px;
		padding: 1em;
		
		max-width: 500px;
		margin: 0 auto;
		
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	
	.watson .mensagens{
		box-sizing: border-box;
		overflow: hidden;
		overflow-y: auto;
		height: 100%;
	}
	
	.watson .mensagens .area{
		display: flex;
		justify-content: flex-end;
		flex-direction: column;
		min-height: 100%;
	}
	
	.watson .mensagens .texto{
		border-radius: 2px;
		box-sizing: border-box;
		padding: .65em;
		margin-top: .5em;
		
		animation: popupmensagem linear .2s;
		animation-iteration-count: 1;
		-webkit-animation: popupmensagem linear .2s;
		-webkit-animation-iteration-count: 1;
		-moz-animation: popupmensagem linear .2s;
		-moz-animation-iteration-count: 1;
		-o-animation: popupmensagem linear .2s;
		-o-animation-iteration-count: 1;
		-ms-animation: popupmensagem linear .2s;
		-ms-animation-iteration-count: 1;
	}
	
	.watson .mensagens .texto:first-child{
		margin-top: 0;
	}
	
	.watson .mensagens .texto.usuario{
		background-color: #ECEFF1;
		color: #1A237E;
		margin-right: 30%;
		
		transform-origin: 0% 100%;
		-webkit-transform-origin: 0% 100%;
		-moz-transform-origin: 0% 100%;
		-o-transform-origin: 0% 100%;
		-ms-transform-origin: 0% 100%;
	}
	
	.watson .mensagens .texto.chatbot{
		background-color: #FF5722;
		color: white;
		font-weight: bold;
		margin-left: 30%;
		
		transform-origin: 100% 100%;
		-webkit-transform-origin: 100% 100%;
		-moz-transform-origin: 100% 100%;
		-o-transform-origin: 100% 100%;
		-ms-transform-origin: 100% 100%;
	}
	
	.watson form.mensagem{
		padding: 0;
		margin-top: 1em;
	}
	
	.watson form.mensagem input{
		border: 2px solid #476A7B;
		border-radius: 3px;
		padding: .5em .8em;
		font-size: 16px;
		display: block;
		box-sizing: border-box;
		width: 100%;
	}
	
	.watson form.mensagem input:focus{
		border: 2px solid #1A237E;
		outline: none;
	}
	
	.watson form.mensagem button{
		background-color: #3F51B5;
		border: none;
		border-radius: 3px;
		display: block;
		padding: .5em 1em;
		width: 100%;
		font-size: 16px;
		color: white;
		margin-top: .5em;
	}
	
	
	/**Animação de Mensagem**/
	
	@keyframes popupmensagem{
	  0% {
		transform:  scaleX(0.30) scaleY(0.30) ;
	  }
	  100% {
		transform:  scaleX(1.00) scaleY(1.00) ;
	  }
	}

	@-moz-keyframes popupmensagem{
	  0% {
		-moz-transform:  scaleX(0.30) scaleY(0.30) ;
	  }
	  100% {
		-moz-transform:  scaleX(1.00) scaleY(1.00) ;
	  }
	}

	@-webkit-keyframes popupmensagem {
	  0% {
		-webkit-transform:  scaleX(0.30) scaleY(0.30) ;
	  }
	  100% {
		-webkit-transform:  scaleX(1.00) scaleY(1.00) ;
	  }
	}

	@-o-keyframes popupmensagem {
	  0% {
		-o-transform:  scaleX(0.30) scaleY(0.30) ;
	  }
	  100% {
		-o-transform:  scaleX(1.00) scaleY(1.00) ;
	  }
	}

	@-ms-keyframes popupmensagem {
	  0% {
		-ms-transform:  scaleX(0.30) scaleY(0.30) ;
	  }
	  100% {
		-ms-transform:  scaleX(1.00) scaleY(1.00) ;
	  }
	}
</style>
<body>
<div id="watson" class="watson">
	<div class="mensagens">
		<div class="area" id="chat">
		</div>
	</div>
	<form id="mensagem" class="mensagem">
		<input type="text" id="texto" name="texto" placeholder="Digite sua mensagem"/>
		<button type="submit">Enviar</button>
	</form>
</div>
<!--Importar jQuery. Retire caso sua página já faça a importação. -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
//Submeter Formulário
$("#mensagem").submit(function(){
	//Caso o usuário envie uma mensagem vazia
	if($("#mensagem #texto").val() === ""){
		//Adiciona na área de Chat a mensagem enviada pelo usuário
		$("#chat").append("<div class=\"texto usuario\">...</div>");
		
		//Faz um scroll para a mensagem mais recente, caso necessário
		$(".mensagens").animate({scrollTop: $("#chat").height()});
		setTimeout(function(){
			//Adiciona uma resposta padrão afirmando que o usuário deixou o campo vazio
			$("#chat").append("<div class=\"texto chatbot\">Você precisa digitar alguma coisa para prosseguir.</div>");
			//Faz um scroll para a mensagem mais recente, caso necessário
			$(".mensagens").animate({scrollTop: $("#chat").height()});
		},1000);
		return false;
	}
	
	//Inicia método AJAX
	$.ajax({
		//Substitua o caminho da URL pelo que você salvou o arquivo de backend
		url: "conversa.php?texto=" + $("#mensagem #texto").val(),
		dataType: 'json', // Determina o tipo de retorno
		beforeSend: function(){
			//Adiciona a mensagem de usuário à lista de mensagens.
			$("#chat").append("<div class=\"texto usuario\">" + $("#mensagem #texto").val() + "</div>");	
		},
		success: function(resposta){
			//Limpa o que o usuário digitou e foca no input para próxima interação.
			$("#mensagem #texto").val("");
			$("#mensagem #texto").focus();
			
			//Caso haja um erro, o Watson retornará a mensagem de erro ao usuário
			//Basta ler o objeto error para o usuário.
			if(resposta.error){
				$("#chat").append("<div class=\"texto chatbot\">" + resposta.error + "</div>");
				return false;
			}
			
			//Colocar a resposta do Watson para o usuário ler
			//A mensagem de texto pode ser lida a partir da lógica
			//do json de exemplo da imagem no post
			var mensagemChatbot  = "<div class=\"texto chatbot\">";
			mensagemChatbot		+= resposta.output.text[0];
			mensagemChatbot		+= "</div>";
			setTimeout(function(){
				$("#chat").append(mensagemChatbot);
				$(".mensagens").animate({scrollTop: $("#chat").height()});
			},1000);
		}
	});

	return false;
});
</script>
</body>
</html>