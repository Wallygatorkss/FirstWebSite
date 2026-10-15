document.addEventListener('DOMContentLoaded', function() {
    const messages = document.querySelectorAll('.message');
    if (messages.length > 0) {
        setTimeout(() => {
            messages.forEach(msg => msg.remove());
        }, 3000);
    }
});