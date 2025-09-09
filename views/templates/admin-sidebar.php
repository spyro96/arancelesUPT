<aside class="sidebar">

    <nav>
        <div class="link <?php echo pagina_actual('admin/dashboard') === true ? 'actual' : ''; ?>">
            <a href="/admin/dashboard"><i class="fa-solid fa-house"></i> Inicio</a>
        </div>
        <?php if ($_SESSION['rol'] === 'admin') { ?>
            <div class="link <?php echo pagina_actual('admin/usuarios') === true ? 'actual' : ''; ?>">
                <a href="/admin/usuarios"><i class="fa-solid fa-users"></i> Usuarios</a>
            </div>
        <?php } ?>
        <div class="link <?php echo pagina_actual('admin/solicitudes') === true ? 'actual' : ''; ?>">
            <a href="/admin/solicitudes"><i class="fa-regular fa-file-lines"></i> Solicitudes</a>
        </div>
        
        <!-- <div class="link <?php echo pagina_actual('admin/solicitud-terceros') === true ? 'actual' : ''; ?>">
            <a href="/admin/solicitud-terceros"><i class="fa-regular fa-file"></i> Solicitud a Terceros</a>
        </div> -->
        
        <?php if ($_SESSION['rol'] === 'admin') { ?>
            <div class="link <?php echo pagina_actual('admin/categorias') === true ? 'actual' : ''; ?>">
                <a href="/admin/categorias"><i class="fa-solid fa-list"></i></i> Categorias</a>
            </div>
        <?php } ?>
        <?php if ($_SESSION['rol'] === 'admin') { ?>
            <div class="link <?php echo pagina_actual('admin/aranceles') === true ? 'actual' : ''; ?>">
                <a href="/admin/aranceles"><i class="fa-regular fa-folder-open"></i> Aranceles</a>
            </div>
        <?php } ?>
        <div class="link <?php echo pagina_actual('reportes') === true ? 'actual' : ''; ?>">
            <a href="/admin/reportes"><i class="fa-solid fa-clipboard"></i> Reportes</a>
        </div>
        <div class="link <?php echo pagina_actual('admin/perfil') === true ? 'actual' : ''; ?>">
            <a href="/admin/perfil"><i class="fa-solid fa-circle-user"></i> Perfil</a>
        </div>
        <?php if ($_SESSION['rol'] === 'admin') { ?>
            <div class="link <?php echo pagina_actual('admin/backup') === true ? 'actual' : ''; ?>">
                <a href="/admin/backup"><i class="fa-solid fa-server"></i> Gestión de BD</a>
            </div>
        <?php } ?>
        <?php if($_SESSION['rol'] === 'admin'){?>
        <div class="link">
            <a href="/admin/manual" target="_blank"><i class="fa-solid fa-circle-info"></i> Ayuda</a>
        </div>
        <?php }?>
    </nav>

    <div class="link cerrar-sesion">
        <a href="" class="cerrar"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
</aside>

<aside class="sidebar-movil">
    <div class="contenedor-cerrarMenu">
        <h2>Menu</h2>
        <img src="/build/img/cerrar.svg" id="cerrar-menu" alt="Cerra Menu">
    </div>

    <nav>
        <div class="link <?php echo pagina_actual('admin/dashboard') === true ? 'actual' : ''; ?>">
            <a href="/admin/dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
        </div>
        <?php if($_SESSION['rol'] === 'admin'){?>
        <div class="link <?php echo pagina_actual('admin/usuarios') === true ? 'actual' : ''; ?>">
            <a href="/admin/usuarios"><i class="fa-solid fa-users"></i> Usuarios</a>
        </div>
        <?php }?>
        <div class="link <?php echo pagina_actual('admin/solicitudes') === true ? 'actual' : ''; ?>">
            <a href="/admin/solicitudes"><i class="fa-regular fa-file-lines"></i> Solicitudes</a>
        </div>
        <?php if($_SESSION['rol'] === 'admin'){?>
        <div class="link <?php echo pagina_actual('admin/categorias') === true ? 'actual' : ''; ?>">
            <a href="/admin/categorias"><i class="fa-solid fa-list"></i> Categorias</a>
        </div>
        <?php }?>
        <?php if($_SESSION['rol'] === 'admin'){?>
        <div class="link <?php echo pagina_actual('admin/aranceles') === true ? 'actual' : ''; ?>">
            <a href="/admin/aranceles"><i class="fa-regular fa-folder-open"></i> Aranceles</a>
        </div>
        <?php }?>
        <div class="link <?php echo pagina_actual('reportes') === true ? 'actual' : ''; ?>">
            <a href="/reportes"><i class="fa-solid fa-clipboard"></i> Reportes</a>
        </div>
        <div class="link <?php echo pagina_actual('admin/perfil') === true ? 'actual' : ''; ?>">
            <a href="/admin/perfil"><i class="fa-solid fa-circle-user"></i> Perfil</a>
        </div>
        <?php if ($_SESSION['rol'] === 'admin') { ?>
            <div class="link <?php echo pagina_actual('admin/backup') === true ? 'actual' : ''; ?>">
                <a href="/admin/backup"><i class="fa-solid fa-server"></i> Gestión de BD</a>
            </div>
        <?php } ?>
        <?php if($_SESSION['rol'] === 'admin'){?>
        <div class="link">
            <a href="/admin/manual" target="_blank"><i class="fa-solid fa-circle-info"></i> Ayuda</a>
        </div>
        <?php }?>
        <div class="link">
            <a href="" class="cerrar"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
        </div>
    </nav>
</aside>