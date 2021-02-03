
@extends('errors.layout')

@section('title_site', __('Exception'))
@section('code', 'No code Error')
@section('message', __($exception->getMessage()))
