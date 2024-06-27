document.getElementById('logout').addEventListener('click', function(event) {
    event.preventDefault();
    window.location.href = 'login.php?logout=true';
});