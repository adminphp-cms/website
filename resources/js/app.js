// Copy buttons of the shell commands: <button data-copy="composer require …">.
document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy]');

    if (!button) {
        return;
    }

    try {
        await navigator.clipboard.writeText(button.dataset.copy);
        button.textContent = 'Copié !';
    } catch {
        button.textContent = 'Copiez à la main';
    }

    setTimeout(() => (button.textContent = 'Copier'), 2000);
});
