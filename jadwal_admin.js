const matkul = document.getElementsByName('matkul')[0];
const hari = document.getElementsByName('hari')[0];
const waktu_mul = document.getElementsByName('waktu_mul')[0];
const waktu_akh = document.getElementsByName('waktu_akh')[0];
const ruang = document.getElementsByName('ruang')[0];
const form = document.getElementById('biodata-form');

const matkulError = document.getElementById('matkul-error');
const hariError = document.getElementById('hari-error');
const waktu_mulError = document.getElementById('waktu-mul-error');
const waktu_akhError = document.getElementById('waktu-akh-error');
const ruangError = document.getElementById('ruang-error');

form.addEventListener('submit', (e) => {
    let hasError = false;

    matkulError.innerText = '';
    hariError.innerText = '';
    waktu_mulError.innerText = '';
    waktu_akhError.innerText = '';
    ruangError.innerText = '';

    
    if (matkul.value.trim() === '') {
        matkulError.innerText = "Masukkan mata kuliah";
        hasError = true;
    } 

    if (hari.value.trim() === '') {
        hariError.innerText = "Masukkan hari";
        hasError = true;
    } 

    if (waktu_mul.value.trim() === '') {
        waktu_mulError.innerText = "Masukkan waktu mulai";
        hasError = true;
    }

    if (waktu_akh.value.trim() === '') {
        waktu_akhError.innerText = "Masukkan waktu akhir";
        hasError = true;
    }

    if (ruang.value === '') {
        ruangError.innerText = "Masukkan kode ruang";
        hasError = true;
    }


    if (hasError) {
        e.preventDefault();
    }
});
