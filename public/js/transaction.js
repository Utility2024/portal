// public/js/transaction.js

document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.getElementById('qty');
    const priceInput = document.getElementById('price');
    const totalPriceInput = document.getElementById('total_price');

    // Event listener untuk menghitung total_price
    qtyInput.addEventListener('input', function() {
        const price = parseFloat(priceInput.value) || 0;
        const qty = parseFloat(qtyInput.value) || 0;
        const totalPrice = price * qty;

        // Update nilai total_price pada input field
        totalPriceInput.value = totalPrice.toFixed(2); // Ubah format sesuai kebutuhan

        // Anda juga bisa menambahkan logika untuk menampilkan atau menyembunyikan pesan atau indikator lain
    });
});

