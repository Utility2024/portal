// public/js/qr-scanner.js
document.getElementById('start-scan').addEventListener('click', function() {
    const html5QrCode = new Html5Qrcode("qr-reader");
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        document.getElementById('qr-result').value = decodedText;
        html5QrCode.stop().then(() => {
            console.log("QR code scanning stopped.");
            const searchInput = document.querySelector('input[type="search"]');
            if (searchInput) {
                searchInput.value = decodedText;
                searchInput.form.submit();
            }
        }).catch(err => {
            console.error("Unable to stop scanning.", err);
        });
    };
    const config = { fps: 10, qrbox: 250 };
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
    .catch(err => {
        console.error("Unable to start scanning.", err);
    });
});
