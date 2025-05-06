document.addEventListener('DOMContentLoaded', function () {
    console.log("Rincian pesanan siap ditampilkan.");

    // Highlight status jika sudah selesai
    const statusValue = document.querySelector('.status-value');
    if (statusValue && statusValue.innerText.toLowerCase().includes('selesai')) {
        statusValue.style.backgroundColor = '#28a745';
    }
});
