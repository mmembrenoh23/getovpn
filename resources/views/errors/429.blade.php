@extends('errors::minimal')

@section('title_site', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
