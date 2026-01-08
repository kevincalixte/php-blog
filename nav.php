<ul>
    <?php if (is_logged_in()) :  ?>
        <li><a href="?page=admin">Admin</a></li>
        <li><a href="?page=logout">Disconnect</a></li>
    <?php else: ?>
        <li><a href="?page=login">Login</a></li>
    <?php endif ?>
</ul>