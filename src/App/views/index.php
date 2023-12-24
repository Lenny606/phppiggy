<!--//in templates we do have access to methods-->
<?php include $this->resolve('/partials/_header.php'); ?>
<?php include $this->resolve('/partials/_footer.php'); ?>
<!--load html / css content from github -->

<?php
//passed as extracted value from array in render method
echo $title;

