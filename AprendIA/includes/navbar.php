<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../img/logo.png" alt="AprendIA Logo" class="admin-logo" style="height: 40px; margin-right: 10px;">
            <span class="fw-bold">AprendIA Admin</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? ' active' : '' ?>" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= basename($_SERVER['PHP_SELF']) === 'usuarios.php' ? ' active' : '' ?>" href="usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-book"></i> Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-gear"></i> Configuración</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="me-3">
                    <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars(Session::get('user_name')); ?>
                </span>
                <a href="../logout.php" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </div>
</nav>
