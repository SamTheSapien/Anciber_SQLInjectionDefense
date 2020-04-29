<?php
//Identificar e fornecer creds da DB
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Create the command and escape all the inline querys
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
//Start Counter
$counter=0;
$nome=$_GET["Nome"];
$email=$_GET["email"];
$morada=$_GET["morada"];
$telemovel=$_GET["telefone"];
$nascimento=$_GET["nascimento"];
//acunetix defense
if(isset($_GET['Nome']) && (strlen($nome)>0)){
$n="Update alunos set Nome = :Nome where ID = :ID";
$n1=$db->prepare($n);
$n1->bindParam(':ID',$id,PDO::PARAM_INT);
$n1->bindParam(':Nome',$nome,PDO::PARAM_STR);
$n1r=$n1->execute();
$counter++;
}
if(isset($_GET['email']) && (strlen($email)>0)){
$e="Update alunos set email = :email where ID = :ID";
$e1=$db->prepare($e);
$e1->bindParam(':ID',$id,PDO::PARAM_INT);
$e1->bindParam(':email',$email,PDO::PARAM_STR);
$e1r=$e1->execute();
$counter++;
}
if(isset($_GET['morada']) && (strlen($morada)>0)){
$m="Update alunos set morada = :morada where ID = :ID";
$m1=$db->prepare($m);
$m1->bindParam(':ID',$id,PDO::PARAM_INT);
$m1->bindParam(':morada',$morada,PDO::PARAM_STR);
$m1r=$m1->execute();
$counter++;
}
if(isset($_GET['telemovel']) && (strlen($telemovel)>0)){
$t="Update alunos set telefone = :telefone where ID = :ID";
$t1=$db->prepare($t);
$t1->bindParam(':ID',$id,PDO::PARAM_INT);
$t1->bindParam(':telefone',$telemovel,PDO::PARAM_INT);
$t1r=$t1->execute();
$counter++;
}
if(isset($_GET['nascimento']) && (strlen($nascimento)>0)){
$dt="Update alunos set nascimento = :nascimento where ID = :ID";
$dt1=$db->prepare($dt);
$dt1->bindParam(':ID',$id,PDO::PARAM_INT);
$dt1->bindParam(':nascimento',$nascimento);
$dt1r=$dt1->execute();
$counter++;
}
if($n1r || $e1r || $m1r || $t1r || $dt1r){
echo ("Utilizador atualizado com sucesso!<br>");
echo ("Foram atualizados $counter registos");
}else{
echo ("ERRO! Utilizador nao atualizado!");
}
}else{
	echo "Não não, por aqui não... ;)";
	echo "<br>";
	die('Error processing: bad or malformed request');
	}
}
$db=null;
?>
