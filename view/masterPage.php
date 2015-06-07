<!DOCTYPE html>
<?php
    include_once 'view/Struttura.php';
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pagina->getTitle() ?> </title>
        <link rel="stylesheet" type="text/css" media="screen" href="./css/normal.css"/>
        <script src="./js/jquery.js"></script>
        <script src="<?php echo $pagina->getJsFile() ?>"></script>
    </head>
    <body>
        <div class="page">
            
            <div class="header">
                <?php include_once $pagina->getHeaderFile(); ?>
            </div>

            <div class="menu">
                <?php include_once $pagina->getMenuFile(); ?>
            </div>
        
        
            <div class="leftBar">
                <?php include_once $pagina->getLeftBarFile(); ?>
            </div>

            <div class="content">
                <?php  include_once $pagina->getContentFile(); ?>
            </div>

            <div class="rightBar">
                <?php include_once $pagina->getRightBarFile(); ?>
            </div>
        
        
            <div class="clear">
                <?php include_once $pagina->getClearFile(); ?>
            </div>

            <div class="footer">
                <?php include_once $pagina->getFooterFile(); ?>
            </div>
            
        </div>
            
    </body>
</html>


