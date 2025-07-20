/* DASHBOARD DE ESTUDIANTE */
document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.querySelector('.user-info');
    const userMenu = document.querySelector('.user-menu');
    if (userInfo && userMenu) {
        userInfo.addEventListener('click', () => {
            userMenu.classList.toggle('visible');
        });
    }

    const toggleBtn = document.querySelector('.noti-toggle');
    const toggleIcon = document.querySelector('.toggle-icon');
    const notiContent = document.querySelector('.coordinador-noti-content');

    if (toggleBtn && toggleIcon && notiContent) {
        toggleBtn.addEventListener('click', () => {
            notiContent.classList.toggle('hidden');
            toggleIcon.textContent = notiContent.classList.contains('hidden') ? '▸' : '▾';
        });
    }
});

async function eliminarNotificacion(id) {
    if (!confirm("¿Estás seguro de borrar esta notificación?")) return;

    try {
        const res = await fetch(`http://localhost:5000/notificaciones/eliminar/${id}`, {
            method: 'DELETE'
        });

        if (res.ok) {
            const notiDiv = document.getElementById(`noti-${id}`);
            if (notiDiv) notiDiv.remove();
        } else {
            alert("❌ No se pudo eliminar la notificación.");
        }
    } catch (e) {
        console.error("Error al eliminar:", e);
        alert("❌ Error al conectar con el servidor.");
    }
}



/* DASHBOARD DEL COORDINADOR */
document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.querySelector('.user-info');
    const userMenu = document.querySelector('.user-menu');
    const notiToggle = document.querySelector('.noti-toggle');
    const notiContent = document.querySelector('.coordinador-noti-content');
    const toggleIcon = document.querySelector('.toggle-icon');

    if (userInfo && userMenu) {
        userInfo.addEventListener('click', () => {
            userMenu.classList.toggle('visible');
        });
    }

    if (notiToggle && notiContent && toggleIcon) {
        notiToggle.addEventListener('click', () => {
            notiContent.classList.toggle('hidden');
            toggleIcon.textContent = notiContent.classList.contains('hidden') ? '▸' : '▾';
        });
    }
});

async function eliminarNotificacion(id) {
    if (!confirm("¿Estás seguro de borrar esta notificación?")) return;

    try {
        const res = await fetch(`http://localhost:5000/notificaciones/eliminar/${id}`, {
            method: 'DELETE'
        });

        if (res.ok) {
            const div = document.getElementById(`noti-${id}`);
            if (div) div.remove();
        } else {
            alert("❌ No se pudo eliminar la notificación.");
        }
    } catch (e) {
        console.error("Error al eliminar:", e);
        alert("❌ Error al conectar con el servidor.");
    }
}



/* DASHBOARD DEL DOCENTE */
document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.querySelector('.user-info');
    const userMenu = document.querySelector('.user-menu');
    if (userInfo && userMenu) {
        userInfo.addEventListener('click', function () {
            userMenu.classList.toggle('visible');
        });
    }

    const toggleBtn = document.querySelector('.noti-toggle');
    const toggleIcon = document.querySelector('.toggle-icon');
    const notiContent = document.querySelector('.coordinador-noti-content');

    if (toggleBtn && toggleIcon && notiContent) {
        toggleBtn.addEventListener('click', () => {
            notiContent.classList.toggle('hidden');
            toggleIcon.textContent = notiContent.classList.contains('hidden') ? '▸' : '▾';
        });
    }
});

async function eliminarNotificacion(id) {
    if (!confirm("¿Estás seguro de borrar esta notificación?")) return;

    try {
        const res = await fetch(`http://localhost:5000/notificaciones/eliminar/${id}`, {
            method: 'DELETE'
        });

        if (res.ok) {
            const notiDiv = document.getElementById(`noti-${id}`);
            if (notiDiv) notiDiv.remove();
        } else {
            alert("❌ No se pudo eliminar la notificación.");
        }
    } catch (e) {
        console.error("Error al eliminar:", e);
        alert("❌ Error al conectar con el servidor.");
    }
}