<nav>      
    <a href="/articles">Articles</a>
           
    <?php if (app\Core\SessionManager::has('authenticated')): ?>
        <a href="/articles/store">Create article</a>      

        <a href="/auth/logout">Log Out</a>
    <?php else: ?>
        <a href="/auth/login">Sign In</a>
   
        <a href="/auth/register">Sign Up</a>
    <?php endif; ?>
</nav>