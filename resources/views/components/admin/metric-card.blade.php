@props([
    'title',
    'valueId' => null,
    'value',
    'subtitle',
    'iconBgColor' => 'bg-[#f3ecdf]',
    'iconTextColor' => 'text-[#5c4432]'
])

<div
  class="relative rounded-2xl border border-[#e2d4c5] bg-[#fffaf5] px-6 py-5 shadow-[0_12px_28px_rgba(92,68,50,0.06)] transition-all hover:shadow-[0_15px_35px_rgba(92,68,50,0.1)]">
  <div class="flex items-start justify-between">
    <div>
      <div class="mb-1 text-[11px] font-bold uppercase tracking-[0.1em] text-[#9a8575]">{{ $title }}</div>
      <div class="mb-1 text-4xl font-extrabold text-[#5c4432]" @if($valueId) id="{{ $valueId }}" @endif>{{ $value }}</div>
      <div class="text-[13px] font-medium text-[#7b6858]">{{ $subtitle }}</div>
    </div>
    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $iconBgColor }} {{ $iconTextColor }}">
      {{ $slot }}
    </div>
  </div>
</div>
