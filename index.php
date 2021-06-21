<?php
include_once './includes/session.php';
require_once './db/connect.php';
require_once './functions/convert-date.php';

$jmlRelawan = $pdo->query("SELECT COUNT(id_pengguna) as id FROM status WHERE status <> 'gagal'");
$jmlOrganisasi = $pdo->query("SELECT COUNT(id_organisasi) as id  FROM organisasi");
$jmlAcara = $pdo->query("SELECT COUNT(id_acara) as id FROM acara");

$acara = $crud->getAcaraLimitOrdered(0, 4, "DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="favicon" sizes="16x16" href="assets/favicon/favicon-16x16.ico" />
    <link rel="icon" type="favicon" sizes="48x48" href="assets/favicon/favicon-48-48.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <meta name="title" content="Relawan Kita | Mudahkan anda mencari relawan">
    <meta name="keywords" content="Relawan, Organisasi, Pengabdian masyarakat, event">
    <!-- <meta name="description" content=""> -->
    <meta name="author" content="Muhammad Pascal Rahmadi">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Stylesheet CSS -->
    <link rel="stylesheet" href="styles/stylesheet.css" />

    <title>Home | Relawan Kita </title>

    <style>
        .carousel-wrapper {
            max-width: 1920px;
            margin: auto;
        }

        .carousel-item img {
            max-height: 500px;
            object-position: center;
            object-fit: cover;
        }

        .content-container {
            max-width: 1440px;
            margin: auto;
        }

        .info-box-wrapper {
            border-radius: 20px;
        }

        .info-box {
            border-right: 2px solid #D7292E;
            padding-left: 50px;
            padding-right: 50px;
        }

        .info-box:last-child {
            border-right: unset;
        }

        .info-box h1,
        .info-box h5 {
            margin-bottom: 0;
            text-align: center;
        }

        .info-box h1 {
            font-weight: bold;
            color: #D7292E;
        }
    </style>
</head>

<body>
    <?php require_once './includes/navbar.php' ?>
    <div class="carousel-wrapper">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img load="lazy" src="https://source.unsplash.com/xch7jXAaqqo/1024x720" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Pembersihan Sampah Pantai Di Bali</h5>
                        <p>OCG atau Ocean Clean Group melaksanakan aksi pembersihan sampah yang ada di pantai bali pada 13 Juni 2021</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img load="lazy" src="https://source.unsplash.com/KmtIl7wI80c/1024x720" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Earth Day Cleanup 2021</h5>
                        <p>Earth Day Cleanup 2021 telah dilaksanakan pada 30 Mei 2021 di Gunung Slamet Purwokerto untuk membersihkan sampah - sampah serta melakukan reboisasi hutan.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img load="lazy" src="https://source.unsplash.com/kY8m5uDIW7Y/1024x720" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Pemberdayaan Masyarakat Pedalaman</h5>
                        <p>Organisasi non profit Kawan Baik melaksanakan aksi pemberdayaan masyarakat pedalaman di daerah Nusa Tenggara Timur di bidang pendidikan, kesehatan, kerajian, dll</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <main class="content-container p-5 pt-3">

        <div class="row mb-4 mt-3">
            <div class="info-box-wrapper col-lg-6 p-4 mx-auto shadow d-flex justify-content-center">
                <div class="info-box">
                    <h1><?= $jmlRelawan->fetch()['id']; ?></h1>
                    <h5>Relawan</h5>
                </div>
                <div class="info-box">
                    <h1><?= $jmlOrganisasi->fetch()['id']; ?></h1>
                    <h5>Organisasi</h5>
                </div>
                <div class="info-box">
                    <h1><?= $jmlAcara->fetch()['id']; ?></h1>
                    <h5>Total Aksi</h5>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 my-2 d-flex justify-content-between">
                <h4 class="font-weight-bold">Aksi Terbaru</h4>
                <a href="cariaktivitas.php">Lihat Semua ></a>
            </div>
            <?php while ($r = $acara->fetch()) : ?>
                <div class="col-3 mb-3 ">
                    <div class="card shadow-sm" style="height: 100%;">
                        <a href="ViewAktivitas.php?id_acara=<?= $r['id_acara'] ?>" rel="noopener noreferrer" class="no-effect-link">
                            <img src="assets/images/image_2021-05-03_14-46-10.png" class="card-img-top " alt="Foto Organisasi">
                            <div class="card-body ">
                                <!-- Nama Acara dan Nama Organisasi -->
                                <span class="text-uppercase p-1 rounded-pill" style="border: 1px solid #DF202E; color:#DF202E; font-size: 8px"><?= $r['nama_jenis_acara']; ?></span>
                                <h5 class="my-2 fw-bold text-capitalize" style="font-size: 18px;"><?= $r['judul_acara']; ?></h5>
                                <small class="mt-3 mb-1 text-muted"><?= $r['nama']; ?></small>
                                <hr class="my-2 border  border-dark">
                                <h6 class="mb-3">Waktu & Lokasi</h6>
                                <div class="d-flex flex-row align-items-center mb-2">
                                    <!-- Icon Kalender dan Tanggal Acara -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                    </svg>
                                    <small class="text-muted offset-1"><?= tgl_indo($r['tanggal_acara']); ?></small>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <!-- Icon Lokasi dan lokasi acara -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                    </svg>
                                    <small class="text-muted offset-1"><?= $r['lokasi']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endwhile ?>
        </div>

        <?php require_once './includes/footer.php'; ?>