@php
    $type = session('status') ? 'success' : 'danger';
@endphp
<div id="alert" {{ $attributes->merge(['class' => 'alert alert-'.$type.' mb-2']) }} style="display: {{ session('message') == null ? 'none' : 'block' }};">{{ session('message') }}</div>