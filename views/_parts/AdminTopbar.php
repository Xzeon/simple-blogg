<div class="admin-topbar">
    <div>
        <h3 class="left">Admin Panel</h3>

        <nav>
            <a href="/" class="<?= !isset($_GET['uri']) ? 'active'  : '' ?>" >Hem</a>
            <a href="/admin/create" class="<?= $_GET['uri'] == "admin/create" ? 'active'  : '' ?>">Nytt inlägg</a>
            <a href="/admin/config" class="<?= $_GET['uri'] == "admin/config" ? 'active'  : '' ?>">Inställningar</a>
        </nav>

        <form action="/login" method="post">
            <input type="submit" name="logout" class="button tiny right logout" id="logout" value="Logga ut">
        </form>
    </div>
</div>