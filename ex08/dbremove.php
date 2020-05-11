<?php
//Falta verificar se o user existe
//Identificar e fornecer creds da DB e prevenir mais que uma query numa linha
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Faz verificacoes ao id
if (isset($_GET['id'])){
$id=$_GET["id"];
if ( is_numeric($id) == true){
filter_var($id, FILTER_SANITIZE_NUMBER_INT);
//Ter a certeza de que existe
$s="Select ID from alunos where ID=:id";
$sq=$db->prepare($s);
$sq->bindParam(":id",$id);
$sq->execute();
$sq->setFetchMode(PDO::FETCH_NUM);
//Check if there is a user with that id
$count = $sq->rowCount();
if($count==0){
die("Não existe utilizador com esse ID!");
}
//Acunetix armor
$sql="Delete from alunos where ID=:id";
$sql2=$db->prepare($sql);
$sql2->bindParam(":id",$id);
$result=$sql2->execute();
//Print
if($result==1){
echo ("Utilizador removido com sucesso!");
}else{
echo ("ERRO! Utilizador nao removido!");
}
}else{
echo "Não não, por aqui não... ;)";
echo "<br>";
die('Error processing: bad or malformed request');
}
}
//Libertar o objeto da base de dados
$db = null;
echo "<a href='ex08inicio.html'>Go back to MainPage!</a>";
?>
