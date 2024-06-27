document.addEventListener('DOMContentLoaded', () => {
    const usuarioIcon = document.querySelector('img[src="img/usuario.png"]');

    if (usuarioIcon) {
        usuarioIcon.addEventListener('click', mostrarMenu);
    }

    document.addEventListener('click', (event) => {
        const menu = document.getElementById('mini-menu');
        if (menu && !menu.contains(event.target) && !usuarioIcon.contains(event.target)) {
            cerrarMenu();
        }
    });

    async function mostrarMenu() {
        const response = await fetch('get_user_info.php');
        const userInfo = await response.json();

        cerrarMenu(); // Cerrar cualquier menú abierto

        const menu = document.createElement('div');
        menu.id = 'mini-menu';
        menu.classList.add('mini-menu');

        menu.innerHTML = `
            <div class="menu-header">
                <span class="close-btn">&times;</span>
            </div>
            <div class="menu-content">
                <p>Hola, ${userInfo.nombre}</p>
                <p>Saldo: ${userInfo.saldo}</p>
                <div class="cafe-gif"></div>
                <div class="luna-gif"></div>
            </div>
        `;

        document.body.appendChild(menu);

        // Calcular posición del menú
        const rect = usuarioIcon.getBoundingClientRect();
        menu.style.top = `${rect.bottom + window.scrollY}px`;
        menu.style.left = `${rect.right + window.scrollX}px`;

        const closeBtn = menu.querySelector('.close-btn');
        closeBtn.addEventListener('click', cerrarMenu);

        setTimeout(() => {
            menu.classList.add('visible');
        }, 10);
    }

    function cerrarMenu() {
        const menu = document.getElementById('mini-menu');
        if (menu) {
            menu.classList.remove('visible');
            setTimeout(() => {
                menu.remove();
            }, 300); // Duración de la animación en CSS
        }
    }
});

