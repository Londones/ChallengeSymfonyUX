let verify = document.getElementById('verify').getAttribute('data-verify');
if (verify == 1) {
    let requestBtn = document.getElementById('request-btn');
    requestBtn.style.pointerEvents = 'none';
    requestBtn.style.cursor = 'default';
    requestBtn.innerHTML = 'Demande de vérification envoyée';
}