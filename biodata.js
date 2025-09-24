const nama = document.getElementsByName('nama')[0];
const alamat = document.getElementsByName('alamat')[0];
const email = document.getElementsByName('email')[0];
const nomor_hp = document.getElementById('nomor_hp');
const foto = document.getElementById('foto');
const form = document.getElementById('biodata-form');

const namaError = document.getElementById('nama-error');
const alamatError = document.getElementById('alamat-error');
const emailError = document.getElementById('email-error');
const nomor_hpError = document.getElementById('hp-error');
const fotoError = document.getElementById('foto-error');

const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

function previewImage(event){
    const input = event.target;
    const preview = document.getElementById('preview')

    if (input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0])
    }
}

form.addEventListener('submit', (e) => {
    let hasError = false;

    namaError.innerText = '';
    alamatError.innerText = '';
    emailError.innerText = '';
    nomor_hpError.innerText = '';
    fotoError.innerText = '';

    if (nama.value.trim() === '') {
        namaError.innerText = "Masukkan nama anda";
        hasError = true;
    } else if (nama.value.length > 50) {
        namaError.innerText = "Nama terlalu panjang";
        hasError = true;
    } else if (nama.value.length < 5) {
        namaError.innerText = "Nama terlalu pendek";
        hasError = true;
    }

    if (alamat.value === '') {
        alamatError.innerText = "Masukkan alamat anda";
        hasError = true;
    } else if (alamat.value.length < 5) {
        alamatError.innerText = "Alamat terlalu pendek";
        hasError = true;
    } else if (alamat.value.length > 100) {
        alamatError.innerText = "Alamat terlalu panjang";
        hasError = true;
    }

    if (email.value === '') {
        emailError.innerText = "Masukkan email anda";
        hasError = true;
    } else if (email.value.length < 6) {
        emailError.innerText = "Email terlalu pendek";
        hasError = true;
    } else if (email.value.length > 100) {
        emailError.innerText = "Email terlalu panjang";
        hasError = true;
    } else if (!emailPattern.test(email.value)) {
        emailError.innerText = "Format email salah";
        hasError = true;
    }

    if (nomor_hp.value === '') {
        nomor_hpError.innerText = "Masukkan nomor HP anda";
        hasError = true;
    } else if (nomor_hp.value.length > 11) {
        nomor_hpError.innerText = "Nomor HP terlalu panjang";
        hasError = true;
    } else if (!/^\d+$/.test(nomor_hp.value)) {
        nomor_hpError.innerText = 'Nomor HP harus berupa angka.';
       hasError = true;
    }


    if (foto.files.length === 0) {
        fotoError.innerText = "Pilih foto anda";
        hasError = true;
    } else {
        const file = foto.files[0];
        if (!allowedTypes.includes(file.type)) {
            fotoError.innerText = "Tipe file tidak didukung. Gunakan JPG atau PNG.";
            hasError = true;
        }
    }

    if (hasError) {
        e.preventDefault();
    }
});