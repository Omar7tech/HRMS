<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'HRMS' }}</title>
    <link rel="preload" href="{{ asset('css/bootstrap.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"></noscript>
</head>
<body>
    @include('components.nav')
