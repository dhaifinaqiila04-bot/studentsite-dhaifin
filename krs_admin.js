const nama_matkul = document.getElementsByName('nama_matkul')[0];
const sks = document.getElementsByName('sks')[0];
const dosen = document.getElementsByName('dosen')[0];
const kelas = document.getElementsByName('kelas')[0];
const jurusan = document.getElementsByName('jurusan')[0];
const semester = document.getElementsByName('semester')[0];
const form = document.getElementById('biodata-form');

const nama_matkulError = document.getElementById('matkul-error');
const sksError = document.getElementById('sks-error');
const dosenError = document.getElementById('dosen-error');
const kelasError = document.getElementById('kelas-error');
const jurusanError = document.getElementById('jurusan-error');
const semesterError = document.getElementById('semester-error');

form.addEventListener('submit', (e) => {
    let hasError = false;

    
    nama_matkulError.innerText = '';
    sksError.innerText = '';
    dosenError.innerText = '';
    kelasError.innerText = '';
    jurusanError.innerText = '';
    semesterError.innerText = '';

    
    if (nama_matkul.value.trim() === '') {
        nama_matkulError.innerText = "Masukkan nama mata kuliah";
        hasError = true;
    } else if (nama_matkul.value.length > 50) {
        nama_matkulError.innerText = "Nama terlalu panjang";
        hasError = true;
    }

    if (sks.value.trim() === '') {
        sksError.innerText = "Masukkan SKS";
        hasError = true;
    } else if (sks.value.length > 2) {
        sksError.innerText = "SKS terlalu panjang";
        hasError = true;
    } else if (!/^\d+$/.test(sks.value)) {
        sksError.innerText = "Harus pakai nomor";
        hasError = true;
    }

    if (dosen.value.trim() === '') {
        dosenError.innerText = "Masukkan nama dosen";
        hasError = true;
    } else if (dosen.value.length > 50) {
        dosenError.innerText = "Nama terlalu panjang";
        hasError = true;
    }

    if (kelas.value.trim() === '') {
        kelasError.innerText = "Masukkan nama kelas";
        hasError = true;
    } else if (kelas.value.length > 10) {
        kelasError.innerText = "Nama terlalu panjang";
        hasError = true;
    }

    if (jurusan.value === '') {
        jurusanError.innerText = "Masukkan jurusan";
        hasError = true;
    }

    if (semester.value.trim() === '') {
        semesterError.innerText = "Masukkan semester";
        hasError = true;
    } else if (semester.value.length > 2) {
        semesterError.innerText = "Semester terlalu panjang";
        hasError = true;
    } else if (!/^\d+$/.test(semester.value)) {
        semesterError.innerText = "Harus pakai nomor";
        hasError = true;
    }

    if (hasError) {
        e.preventDefault();
    }
});
