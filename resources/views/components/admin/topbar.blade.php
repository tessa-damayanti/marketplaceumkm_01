<div class="topbar sticky top-0 z-20">
  <div class="flex items-center gap-3">
    <button type="button" class="md:hidden p-2 -ml-2 text-[#5c4432]" onclick="toggleMobileSidebar()">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <span class="topbar-title" id="topbar-title">{{ $title ?? 'Dashboard' }}</span>
  </div>
  <span class="topbar-greeting">Selamat Datang, Admin</span>
</div>
