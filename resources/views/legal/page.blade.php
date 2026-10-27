@extends('layouts.app')
@section('title', $documentTitle . ' | ROXEL INVEST')
@section('meta_description', $documentTitle)
@section('body_class', 'page-legal')

@section('content')
<article class="legal-document" aria-labelledby="legal-title">
    @include('legal.' . $document)
</article>
@endsection
