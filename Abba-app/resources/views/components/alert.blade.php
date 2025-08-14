@props([
    'type' => 'info', 
    'message' => '',
])

@php
  $validTypes = ['success', 'error', 'warning', 'info'];
    $type = in_array($type, $validTypes) ? $type : 'info';
    $icons = [
        'success' => '✔️',
        'error'   => '❌',
        'warning' => '⚠️',
        'info'    => 'ℹ️',
    ];

    $gradients = [
        'success' => 'radial-gradient(circle at 20% 20%, #75b89dff, transparent),
                      radial-gradient(circle at 80% 40%, #0f9d6fff, transparent),
                      radial-gradient(circle at 50% 80%, #28a07fff, transparent)',
        'error' => 'radial-gradient(circle at 20% 20%, #fca5a5cc, transparent),
                    radial-gradient(circle at 80% 40%, #f87171cc, transparent),
                    radial-gradient(circle at 50% 80%, #ef4444cc, transparent)',
        'warning' => 'radial-gradient(circle at 20% 20%, #fde68acc, transparent),
                      radial-gradient(circle at 80% 40%, #fbbf24cc, transparent),
                      radial-gradient(circle at 50% 80%, #f59e0bcc, transparent)',
        'info' => 'radial-gradient(circle at 20% 20%, #bfdbfecc, transparent),
                   radial-gradient(circle at 80% 40%, #60a5facc, transparent),
                   radial-gradient(circle at 50% 80%, #3b82f6cc, transparent)',
    ];

    $alertId = 'alert-' . uniqid();
@endphp

<div id="{{ $alertId }}" style="position: relative; overflow: hidden; border-left: 4px solid #000; padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.2);" class="alert-fade-in">

    {{-- Fondo animado --}}
    <div style="position: absolute; inset: 0; z-index: 0; background: {{ $gradients[$type] }}; animation: moveGradient 6s infinite alternate;"></div>

    {{-- Contenido --}}
    <div style="position: relative; z-index: 1; display: flex; align-items: center; color: #000;">
        <span style="font-size: 1.5rem; margin-right: 0.5rem;">{{ $icons[$type] }}</span>
        <span style="font-weight: bold;">{{ $message }}</span>
    </div>
</div>

<style>
@keyframes moveGradient {
    0% { background-position: 0 0, 50% 50%, 100% 100%; }
    100% { background-position: 50% 50%, 100% 0, 0 100%; }
}

.alert-fade-in {
    opacity: 0;
    transform: translateY(-10px);
    animation: fadeIn 0.5s forwards;
}

@keyframes fadeIn {
    to { opacity: 1; transform: translateY(0); }
}

.alert-fade-out {
    opacity: 0 !important;
    transform: translateY(-10px);
    transition: opacity 0.5s, transform 0.5s;
}
</style>

<script>
setTimeout(() => {
    const el = document.getElementById('{{ $alertId }}');
    if(el){
        el.classList.add('alert-fade-out');
        setTimeout(() => el.remove(), 500);
    }
}, 4000);
</script>
