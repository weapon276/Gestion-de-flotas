function toggleNotifications() {
    document.getElementById('notificationsPanel').classList.toggle('active');
}

function toggleUserMenu() {
    document.getElementById('userDropdown').classList.toggle('active');
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

function logout() {
    window.location.href = 'cerrar_sesion.php';
}

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            if (item.querySelector('.nav-arrow')) {
                e.stopPropagation();
                item.classList.toggle('expanded');
            }
        });
    });

    sidebar.addEventListener('click', (e) => {
        if (e.target === sidebar || e.target.classList.contains('logo')) {
            sidebar.classList.toggle('pinned');
        }
    });

    sidebar.addEventListener('mouseleave', () => {
        if (!sidebar.classList.contains('pinned')) {
            navItems.forEach(item => item.classList.remove('expanded'));
        }
    });

    document.addEventListener('click', (e) => {
        const isClickInsideSidebar = sidebar.contains(e.target);
        const isClickInsideNotifications = document.querySelector('.notifications-dropdown').contains(e.target);
        const isClickInsideUserMenu = document.querySelector('.user-menu').contains(e.target);

        if (!isClickInsideSidebar && !isClickInsideNotifications && !isClickInsideUserMenu) {
            sidebar.classList.remove('active');
            document.getElementById('notificationsPanel').classList.remove('active');
            document.getElementById('userDropdown').classList.remove('active');
        }
    });
});

let inactivityTime = function () {
    let time;
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;

    function logout() {
        alert("Se cerrará la sesión por inactividad.");
        window.location.href = 'cerrar_sesion.php';
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 30000000);
    }
};

inactivityTime();
