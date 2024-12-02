<!DOCTYPE html>
<html lang="en">

<?php $title = "AISLE $id - $category"; ?>
<?php //include('../components/head.php'); ?>

<body>
<pre>
    <?php
    var_dump($aisle); // El dump and die en el controlador valida que las variables pasan a la vista, pero no se reciben
    var_dump($category);
    ?>
</pre>
    <?php //include('../components/header.php'); ?>
    <h1>This page maps Aisle <?= $id ?> - Section : <?= $category ?></h1>
    <!--<h2> <?php// if ($category) {echo "This view will map the aisle \"{$aisle}\" and the products stored in the shelves \"{$category}\"...";}
        //else {echo "This view will map the aisle \"{$aisle}\".";}?></h2> -->
</body>
</html>
