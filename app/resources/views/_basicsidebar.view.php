<nav class="navbar navbar-inverse sidebar-left collapse navbar-collapse no-transition" id="sidebar">
    <?php if (isset($_SESSION['nimi'])) : ?>
        <p class="navbar-text"><?php echo $_SESSION['nimi']; ?></p>
    <?php endif; ?>
    <a class="navbar-link"href="/logout">Kirjaudu ulos</a>
    <hr>
    <ul class="nav navbar-nav">
        <?php if (! urlMatches('/-home$/')) : ?>
            <li><a href="/student-home" class="button">Takaisin<br>etusivulle</a> </li>
        <?php endif; ?>
    </ul>
</nav>


