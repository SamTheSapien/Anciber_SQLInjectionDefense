<?php
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
//Identificar e fornecer creds da DB
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Create the command and escape all the inline querys
$nome=$_GET["Nome"];
$email=$_GET["email"];
$morada=$_GET["morada"];
$telemovel=$_GET["telefone"];
$nascimento=$_GET["nascimento"];
//Verificacoes
if(strpos($email,"@")==false){
die("Email incorreto!");
}
if (is_numeric($telemovel) == false){
die("Numero de telemovel incorreto");
}
filter_var($telemovel, FILTER_SANITIZE_NUMBER_INT);
$num_length = strlen((string)$telemovel);
if($num_length!=9){
die("O telemovel tem de ter obrigatoriamente 9 digitos!");
}
if((validateDate($nascimento,"Y-m-d")==false)){
die("Data de nascimento incorreta!");
}
$time=date("Y-m-d",time());
$now=date_create_from_format("Y-m-d",$time);
$date=date_create_from_format("Y-m-d",$nascimento);
$date2=$date->format("Y-m-d");
$diff=date_diff($date,$now,FALSE);
if($diff->format("%r%d")<0){
echo("Data de nascimento incorreta!<br>");
die("Tens a certeza que com essa idade podes estar aqui?");
}
//acunetix defense
$sql="Insert into alunos (Nome,email,morada,telefone,nascimento) values (:Nome,:email,:morada,:telefone,:nascimento)";
$sql2=$db->prepare($sql);
$sql2->bindParam(':Nome',$nome,PDO::PARAM_STR);
$sql2->bindParam(":email",$email,PDO::PARAM_STR);
$sql2->bindParam(":morada",$morada,PDO::PARAM_STR);
$sql2->bindParam(":telefone",$telemovel,PDO::PARAM_INT);
$sql2->bindParam(":nascimento",$date2);
$result=$sql2->execute();
if($result==1){
echo ("Utilizador inserido com sucesso!");
}else{
echo ("ERRO! Utilizador nao inserido!");
}
$db=null;
?>
