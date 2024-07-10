document.addEventListener('DOMContentLoaded', function () {
    const messageField = document.getElementById('message');
    const messageCounter = document.getElementById('messageCounter');

    if (messageField && messageCounter) {
        messageField.addEventListener('input', function () {
            const maxLength = messageField.getAttribute('maxlength');
            const currentLength = messageField.value.length;
            messageCounter.textContent = `${currentLength} / ${maxLength}`;
        });
    }
});
