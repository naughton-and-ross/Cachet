@extends('layout.master')

@section('bodyClass', 'no-padding')

@section('outer-content')
@include('partials.nav')
@stop

@section('content')
<h1>{{ $schedule->name }} <small>{{ formatted_date($schedule->scheduled_at) }}</small></h1>

<hr>

<div class="markdown-body">
    {!! $schedule->formattedMessage !!}
</div>

@if($schedule->components)
<ul class="list-group">
    @foreach ($schedule->components as $component)
    <li class="list-group-item">{{ $component->name }}</li>
    @endforeach
</ul>
@endif
@stop
