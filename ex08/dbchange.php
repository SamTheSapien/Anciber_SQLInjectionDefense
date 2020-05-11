<?php
//Identificar e fornecer creds da DB
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Obter o id quer na primeira vez com o get ou nas seguintes
//com o postno formulario
if (isset($_GET['id'])){
$id=$_GET["id"];
} else $id=$_POST["id"];
//sanitize id
if ( is_numeric($id) == true){
filter_var($id, FILTER_SANITIZE_NUMBER_INT);
} else die("<span style='color:#FF0000;text-align:center;'>O id nao é válido</span>");
//Ter a certeza de que existe (ir buscar a bd)
$s="Select * from alunos where ID=:id";
$sq=$db->prepare($s);
$sq->bindParam(":id",$id);
$sq->execute();
$sq->setFetchMode(PDO::FETCH_NUM);
//Check if there is a user with that id
$count = $sq->rowCount();
if($count==0){
die("<span style='color:#FF0000;text-align:center;'>Não existe utilizador com esse ID!</span");
}
//Ir buscar os valores do utilizador
while($row=$sq->fetch()){
$ID=$row[0];
$Nome=$row[1];
$Email=$row[2];
$Morada=$row[3];
$Telefone=$row[4];
$Nascimento=$row[5];
echo ("Utilizador encontrado!");
}
//Start Counter
//Receber os valores do formulario
$counter=0;
$idPost=$_POST["id"];
$nome=$_POST["nome"];
$email=$_POST["email"];
$morada=$_POST["morada"];
$telemovel=$_POST["telefone"];
$nascimento=$_POST["nascimento"];
//acunetix defense
//aqui comeca caso o formulario seja ativado 
if(isset($_POST["new"]) && $_POST["new"]==1 ){
//input validations
if(strcmp($Nome,$nome)!=0){
if(isset($_POST['nome']) && (strlen($nome)>0)){
$n="UPDATE alunos SET Nome = :Nome WHERE ID = :ID";
$n1=$db->prepare($n);
$n1->bindParam(':ID',$idPost,PDO::PARAM_INT);
$n1->bindParam(':Nome',$nome,PDO::PARAM_STR);
$n1r=$n1->execute();
$counter++;
}
}
if(strcmp($Email,$email)!=0){
if(isset($_POST['email']) && (strlen($email)>0)){
$e="Update alunos set email = :email where ID = :ID";
$e1=$db->prepare($e);
$e1->bindParam(':ID',$idPost,PDO::PARAM_INT);
$e1->bindParam(':email',$email,PDO::PARAM_STR);
$e1r=$e1->execute();
$counter++;
}
}
if(strcmp($Morada,$morada)!=0){
if(isset($_POST['morada']) && (strlen($morada)>0)){
$m="Update alunos set morada = :morada where ID = :ID";
$m1=$db->prepare($m);
$m1->bindParam(':ID',$idPost,PDO::PARAM_INT);
$m1->bindParam(':morada',$morada,PDO::PARAM_STR);
$m1r=$m1->execute();
$counter++;
}
}
if(strcmp($Telefone,$telemovel)!=0){
if(isset($_POST['telefone']) && (strlen($telemovel)>0)){
$t="Update alunos set telefone = :telefone where ID = :ID";
$t1=$db->prepare($t);
$t1->bindParam(':ID',$idPost,PDO::PARAM_INT);
$t1->bindParam(':telefone',$telemovel,PDO::PARAM_INT);
$t1r=$t1->execute();
$counter++;
}
}
if(strcmp($Nascimento,$nascimento)!=0){
if(isset($_POST['nascimento']) && (strlen($nascimento)>0)){
$dt="Update alunos set nascimento = :nascimento where ID = :ID";
$dt1=$db->prepare($dt);
$dt1->bindParam(':ID',$idPost,PDO::PARAM_INT);
$dt1->bindParam(':nascimento',$nascimento);
$dt1r=$dt1->execute();
$counter++;
}
}
if($n1r || $e1r || $m1r || $t1r || $dt1r){
echo ("<br> <span style='color:#008000;text-align:center;'>Utilizador $nome atualizado com sucesso!</span><br>");
echo ("<span style='color:#008000;text-align:center;'>Foram atualizados $counter registos </span> <br>");
}else{ 
echo ("<br><span style='color:#FF0000;text-align:center;'>Nada para atualizar!</span>");
}
 
//}else{
	//echo "Não não, por aqui não... ;)";
	//echo "<br>";
	//die('Error processing: bad or malformed request');
//	echo "Alterações ainda não efetuadas...";
//	}
//caso nao seja ativado
}
$db=null;
?>
<form action="/ex08/dbchange.php" method="post">
<input type="hidden" name="new" value="1"/>
Id:<br>
<input type="text" name="id" value="<?php echo $id; ?>"><br>
Nome:<br>
<input type="text" name="nome" value="<?php echo $Nome; ?>"> <br>
Email:<br>
<input type="text" name="email" value="<?php echo $Email; ?>"><br>
Morada:<br>
<input type="text" name="morada" value="<?php echo $Morada; ?>"><br>
Telefone:<br>
Formato: 9 numeros<br>
<input type="text" name="telefone" value="<?php echo $Telefone; ?>"><br>
Data de Nascimento:<br>
Formato: YYYY-MM-DD<br>
<input type="text" name="nascimento" value="<?php echo $Nascimento; ?>"><br>
<input type="submit" value="Submit" >
</form>
<a href='showdb.php'>See Results!</a><br>
<a href='ex08inicio.html'>Go back to MainPage!</a>
