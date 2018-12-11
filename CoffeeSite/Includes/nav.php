<nav id="navigation">
    <ul id="nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="Coffee.php">Shop</a></li>
        <?php 
    if(isset($_SESSION['email'])){
        echo '<li><a href="logged_out.php">Log out</a></li>';
    }else{
        echo '<li><a href="login.php">Log in</a></li>';
    }
    ?>
    <?php 
    if(isset($_SESSION['email']) && $_SESSION['admin'] == "1"){
        echo"<li><a href=\"admin.php\">Admin</a></li>";
    }
    echo"<li><a href=\"cart_view.php\">View Cart</a></li>";
    ?>    
    </ul>
</nav>