<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?></title>

    <link rel="apple-touch-icon" sizes="180x180"
        href="<?= base_url('assets/') ?>assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?= base_url('assets/') ?>assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?= base_url('assets/') ?>assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/') ?>assets/img/favicons/favicon.ico">
    <link rel="manifest" href="<?= base_url('assets/') ?>assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="<?= base_url('assets/') ?>assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">

    <link href="<?= base_url('assets/') ?>assets/css/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/ded791e88a.js" crossorigin="anonymous"></script>
    <link href="<?= base_url('assets/') ?>fontawesome/css/all.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<style>
body,
html {
    height: 100%
}

#mainNav #navbarSupportedContent .navbar-nav>li>a:focus:hover,
#mainNav #navbarSupportedContent .navbar-nav>li>a:hover {
    background-color: #3966cc;
    border-radius: 5px;
    color: white;
}

#cdbtn:hover {
    background: lightskyblue;
}

#Thecard {
    box-shadow: rgba(33, 85, 205, 0.25) 0px 4px 8px -2px,
        rgba(33, 85, 205, 0.08) 0px 0px 0px 1px;
}

.search-box {
    top: 50%;
    left: 50%;
    position: absolute;
    transform: translate(-50%, -50%);
}
</style>

<body>