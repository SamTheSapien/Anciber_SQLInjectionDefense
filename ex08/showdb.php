<?php
//Falta verificar se o user existe
//Identificar e fornecer creds da DB e prevenir mais que uma query numa linha
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Create the command
$sql="Select ID,Nome,email,morada,telefone,nascimento from alunos";
$sql2=$db->prepare($sql);
$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_NUM);
//Check if there is no users
$count = $sql2->rowCount();
//output data of each row
if($count!=0){
echo "<table border='1'>";
echo "<tr>"; 
echo "<th align='center'>Id</th><th>Nome</th><th>Email</th><th>Morada</th><th>Telefone</th><th>Data de Nascimento</th><th>Apagar</th><th>Modificar</th>";
echo "</tr>";
while($row=$sql2->fetch()){
	$id=$row[0];
	echo "<tr><td>".$id."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td><a href='/ex08/dbremove.php?id=".$id."'>Apagar</a></td><td><a href='/ex08/dbchange.php?id=".$id."'>Modificar</a></td></tr>";
}
echo "</table>";
}else{
echo "0 results found";
}
$db = null;
echo "<a href='ex08inicio.html'>Go back to MainPage!</a>";
?>
