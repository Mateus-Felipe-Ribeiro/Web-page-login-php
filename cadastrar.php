<?php
session_start();
include('conexao.php');

$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$usuario = mysqli_real_escape_string($conexao, trim($_POST['usuario']));
$senha = mysqli_real_escape_string($conexao, trim(md5($_POST['senha'])));
/*
usa-se trim para retirar o espaço do inicio e do fim da string
criptografia da senha em MD5 (php)
seleciona na tabela do banco se há algum usuario com o mesmo nome
*/
$sql = "select count(*) as total from usuario where usuario = '$usuario'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] == 1) {
	$_SESSION['usuario_existe'] = true;
	header('Location: cadastro.php');
	exit;
}

//inserção na tabela, função NOW() pega a data e horário do momento do cadastro
$sql = "INSERT INTO usuario (nome, usuario, senha, data_cadastro) VALUES ('$nome', '$usuario', '$senha', NOW())";

//usa-se 3 igual para validar que ambos os lados são TRUE, regra de identação php
if($conexao->query($sql) === TRUE) {
	$_SESSION['status_cadastro'] = true;
}

//finalixa conexão e retorna para cadastro.php
$conexao->close();

header('Location: cadastro.php');
exit;

?>