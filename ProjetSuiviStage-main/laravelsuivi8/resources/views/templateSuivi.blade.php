<?php
  $titre = "Suivi";
  $support = getenv('SUPPORT_MYSERVICES');
?>

@extends('template')

@section('head')


  {{-- Semble inutile ? <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}







@endsection

@section('style')
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}" media="screen"/>
@endsection

@section('pagescripts')
  @yield('scriptsSuivi')

@endsection
