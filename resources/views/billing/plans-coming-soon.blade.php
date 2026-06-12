<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NidoReal') }} - Planes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white shadow-xl rounded-2xl max-w-md w-full">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Próximamente</h1>
        <p class="text-gray-600 mb-8">Esta página mostrará las opciones de actualización de planes en la Fase 6 del
            proyecto.</p>
        <a href="{{ route('filament.agency.pages.dashboard', ['tenant' => auth()->user()->agencies->first()?->id ?? '']) }}"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
            Volver al panel
        </a>
    </div>
</body>

</html>
