<?php

session_start();

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

  <link rel="stylesheet" href="./styles/stylesheet.css" />

  <title><?= $title; ?> | Relawan Kita </title>
</head>

<body>
  <?php require_once 'navbar.php' ?>
  <main class="container py-5">