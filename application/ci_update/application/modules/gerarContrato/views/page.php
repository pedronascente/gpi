<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerar Contrato</title>
    <?php echo isset($assets['css'])?$assets['css']:'';?>
    <?php echo isset($assets['javaScriptHeader'])?$assets['javaScriptHeader']:'';?>
</head>
<body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php echo $content; ?>
        </div>
      </div>
    </div>  
    <?php echo isset($assets['javaScriptFooter'])?$assets['javaScriptFooter']:'';?>
</body>
</html>
