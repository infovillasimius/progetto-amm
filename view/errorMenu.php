<div class="errorMenu">
    <br/>       
    <a href="index.php">Home</a> <br/><br/>
    <?php
    if (isset($_SESSION["op"])) {

        echo '<a href="index.php?amp;page=logout">Logout</a>';
    } else {

        echo '<a href="index.php?amp;page=login">Login</a>';
    }
    ?>   
</div>
