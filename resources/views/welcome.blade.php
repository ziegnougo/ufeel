@extends('layouts.app')

@section('content')
<div class="text-center py-20">
    <h1 class="text-4xl font-black text-primary">Bienvenue sur UFEEL</h1>
    <p class="mt-4 text-gray-500">Redirecting...</p>
    <script>window.location = "{{ route('home') }}"</script>
</div>
@endsection
