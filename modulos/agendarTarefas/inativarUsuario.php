<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
      <?php

      include_once('../../Config.inc.php');
        $username = USER;
        $password = PASS;
        $dbname = DBSA;

        $data_final = date('Y-m-d');
        $ativo = 2;
        try {
            $conn = new PDO('mysql:host=localhost;dbname='.$dbname, $username, $password);
            $conn->exec('SET @orderA := 0; SET @orderB := 0;');
            $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);  
            $stmt = $conn->prepare('SELECT data_logado as ss,id,CAST(data_logado AS DATE) as data_logado,nome,ativo FROM usuarios  where ativo =1  order by data_logado asc   ');
            $stmt->execute();

            echo '<table class="table table-hover table-condensed">';
                echo '<th>Id</th>';
                echo '<th>Nome</th>';
                echo '<th>Data Atual</th>';
                echo '<th>Data Logado</th>';
                echo '<th>Ativo ?</th>';
                echo '<th>Dias S/ se Logar</th>';
                foreach($stmt->fetchAll() as $k => $row) {	
                    // Calcula a diferença em segundos entre as datas
                    $diferenca = strtotime($data_final) - strtotime($row['data_logado']);
                    // Calcula a diferença em dias
                    $dias = (int) floor($diferenca / (60 * 60 * 24));
                    $ATIVO =($row['ativo']==1)?'SIM':'NÃO';
                     if($dias >=90){
                        $stmt = $conn->prepare("UPDATE usuarios SET ativo = :ativo WHERE id =:id");
                        $stmt->bindParam(':ativo',$ativo, PDO::PARAM_INT); 
                        $stmt->bindParam(':id',$row['id'], PDO::PARAM_INT); 
                        $stmt->execute();
                    }
                    echo '<tr>';
                        echo '<td>'.$row['id'].'</td>';
                        echo '<td>'.  utf8_encode($row['nome']).'</td>';
                        echo '<td>'.date('d/m/Y').'</td>';
                        echo '<td>'.$row['ss'].'</td>';
                        echo '<td>'.$ATIVO.'</td>';
                        echo '<td>'.$dias.'</td>';
                    echo '</tr>';        
                }
            echo '</table>';
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        ?>
    </body>
</html>