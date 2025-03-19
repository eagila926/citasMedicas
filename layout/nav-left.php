<!-- ========== Top Navbar Start ========== -->
<nav class="top-navbar">
    <div class="nav-container">
        <!-- LOGO -->
        <div class="logo">
            <a href="index.html" class="logo-text">
                <i class="mdi mdi-assistant"></i> Annex
            </a>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav-menu">
            <li><a href="index.php"><i class="mdi mdi-calendar-clock"></i> Agenda</a></li>
            <li><a href="pacientes.php"><i class="mdi mdi-account"></i> Pacientes</a></li>
            <li><a href="libros.php"><i class="mdi mdi-book"></i> Libros</a></li>
        </ul>
    </div>
</nav>
<!-- ========== Top Navbar End ========== -->

<style>
    /* General Navbar Styling */
    .top-navbar {
        width: 100%;
        background-color: #2c3e50;
        padding: 10px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 90%;
        max-width: 1200px;
    }

    .logo a {
        color: #ffffff;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
    }

    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }

    .nav-menu li {
        margin: 0 15px;
    }

    .nav-menu li a {
        text-decoration: none;
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
        transition: 0.3s;
    }

    .nav-menu li a:hover {
        color: #f39c12;
    }
</style>
