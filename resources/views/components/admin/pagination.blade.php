@props(['infoId', 'infoText'])

<div class="pagi-row border-t border-[#f0e7dd] bg-white px-6 py-4">
  <span @if($infoId) id="{{ $infoId }}" @endif class="text-xs font-semibold text-[#9a8575]">{{ $infoText }}</span>
  <div class="pagi-btns">
    <button class="pagi-btn">
      <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M15 18l-6-6 6-6" />
      </svg>
    </button>
    <button class="pagi-btn active">1</button>
    <button class="pagi-btn">
      <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 5l6 6-6 6" />
      </svg>
    </button>
  </div>
</div>
