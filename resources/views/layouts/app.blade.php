<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Evencraft') - Evencraft Management System</title>

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    /* ==========================================================================
       CSS VARIABLES & BASE STYLES
       ========================================================================== */
    :root {
      --primary: #4f46e5;
      --primary-hover: #4338ca;
      --primary-light: #e0e7ff;
      --primary-text: #3730a3;

      --slate-50: #f8fafc;
      --slate-100: #f1f5f9;
      --slate-200: #e2e8f0;
      --slate-300: #cbd5e1;
      --slate-400: #94a3b8;
      --slate-500: #64748b;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1e293b;
      --slate-900: #0f172a;

      --emerald-50: #ecfdf5;
      --emerald-500: #10b981;
      --emerald-700: #047857;

      --amber-50: #fffbeb;
      --amber-500: #f59e0b;
      --amber-700: #b45309;

      --rose-50: #fff1f2;
      --rose-500: #f43f5e;
      --rose-700: #be123c;

      --sidebar-width: 280px;
      --header-height: 70px;
      --radius-sm: 6px;
      --radius-md: 10px;
      --radius-lg: 14px;
      --radius-xl: 18px;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.08), 0 2px 4px -2px rgb(0 0 0 / 0.06);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.08), 0 4px 6px -4px rgb(0 0 0 / 0.04);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background-color: var(--slate-100);
      color: var(--slate-800);
      min-height: 100vh;
      display: flex;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* ==========================================================================
       LAYOUT APP CONTAINER
       ========================================================================== */
    .app-container {
      display: flex;
      width: 100%;
      min-height: 100vh;
      position: relative;
    }

    /* ==========================================================================
       SIDEBAR NAVIGATION
       ========================================================================== */
    .sidebar {
      width: var(--sidebar-width);
      background: #ffffff;
      border-right: 1px solid var(--slate-200);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 50;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-brand {
      padding: 20px 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid var(--slate-100);
    }

    .brand-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%);
      color: #ffffff;
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 1.25rem;
      box-shadow: 0 4px 10px rgba(79, 70, 229, 0.35);
    }

    .brand-text h2 {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--slate-900);
      line-height: 1.2;
    }

    .brand-text span {
      font-size: 0.72rem;
      color: var(--slate-500);
      font-weight: 500;
    }

    .sidebar-nav {
      flex: 1;
      overflow-y: auto;
      padding: 18px 14px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-section-title {
      font-size: 0.68rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--slate-400);
      padding: 14px 12px 6px 12px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 9px 12px;
      border-radius: var(--radius-md);
      color: var(--slate-600);
      font-size: 0.86rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .nav-item-content {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .nav-item svg {
      width: 18px;
      height: 18px;
      stroke-width: 2;
      stroke: currentColor;
      fill: none;
      flex-shrink: 0;
      transition: stroke 0.2s;
    }

    .nav-item:hover {
      background-color: var(--slate-50);
      color: var(--primary);
    }

    .nav-item.active {
      background-color: var(--primary-light);
      color: var(--primary);
      font-weight: 600;
    }

    .nav-item.active svg {
      stroke: var(--primary);
    }

    .tag-badge {
      font-size: 0.65rem;
      font-weight: 600;
      padding: 2px 7px;
      border-radius: 9999px;
      background: var(--slate-100);
      color: var(--slate-600);
    }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid var(--slate-200);
      background-color: #ffffff;
    }

    .user-snippet {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 6px;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: var(--primary-light);
      color: var(--primary);
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      flex-shrink: 0;
      border: 1px solid rgba(79, 70, 229, 0.2);
    }

    .user-info {
      flex: 1;
      overflow: hidden;
    }

    .user-name {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--slate-800);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .user-role {
      font-size: 0.72rem;
      color: var(--slate-500);
    }

    /* ==========================================================================
       MAIN CONTENT WRAPPER & TOP HEADER
       ========================================================================== */
    .main-wrapper {
      flex: 1;
      margin-left: var(--sidebar-width);
      display: flex;
      flex-direction: column;
      min-width: 0;
      min-height: 100vh;
    }

    .top-header {
      height: var(--header-height);
      background-color: #ffffff;
      border-bottom: 1px solid var(--slate-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      position: sticky;
      top: 0;
      z-index: 30;
    }

    .mobile-toggle {
      display: none;
      background: none;
      border: 1px solid var(--slate-200);
      border-radius: var(--radius-sm);
      padding: 6px 10px;
      font-size: 1.2rem;
      cursor: pointer;
      color: var(--slate-700);
    }

    .badge-role {
      background-color: var(--slate-100);
      color: var(--slate-600);
      padding: 6px 12px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      border-radius: var(--radius-md);
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      border: 1px solid transparent;
      transition: all 0.2s ease;
    }

    .btn-primary {
      background-color: var(--primary);
      color: #ffffff;
    }

    .btn-primary:hover {
      background-color: var(--primary-hover);
    }

    .btn-secondary {
      background-color: #ffffff;
      color: var(--slate-700);
      border-color: var(--slate-300);
    }

    .btn-secondary:hover {
      background-color: var(--slate-50);
      border-color: var(--slate-400);
    }

    .btn-danger-outline {
      background-color: transparent;
      color: var(--rose-700);
      border-color: var(--rose-500);
    }

    .btn-danger-outline:hover {
      background-color: var(--rose-50);
    }

    .btn svg {
      width: 16px;
      height: 16px;
      stroke-width: 2;
      stroke: currentColor;
      fill: none;
    }

    /* ==========================================================================
       CONTENT BODY & FLASH ALERTS
       ========================================================================== */
    .content-body {
      padding: 32px;
      flex: 1;
    }

    .alert {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 14px 18px;
      border-radius: var(--radius-md);
      margin-bottom: 24px;
      font-size: 0.88rem;
      border: 1px solid transparent;
      box-shadow: var(--shadow-sm);
    }

    .alert-success {
      background-color: var(--emerald-50);
      border-color: #a7f3d0;
      color: var(--emerald-700);
    }

    .alert-error {
      background-color: var(--rose-50);
      border-color: #fecdd3;
      color: var(--rose-700);
    }

    .alert-warning {
      background-color: var(--amber-50);
      border-color: #fde68a;
      color: var(--amber-700);
    }

    .alert-icon {
      flex-shrink: 0;
      width: 20px;
      height: 20px;
      stroke: currentColor;
      stroke-width: 2;
      fill: none;
      margin-top: 1px;
    }

    .alert ul {
      margin-top: 6px;
      padding-left: 20px;
    }

    .alert li {
      margin-bottom: 3px;
    }

    /* Footer */
    .main-footer {
      padding: 20px 32px;
      border-top: 1px solid var(--slate-200);
      background-color: #ffffff;
      color: var(--slate-500);
      font-size: 0.8rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Mobile backdrop */
    .sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.4);
      z-index: 40;
    }

    /* ==========================================================================
       RESPONSIVE BREAKPOINTS
       ========================================================================== */
    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .sidebar-backdrop.open {
        display: block;
      }

      .main-wrapper {
        margin-left: 0;
      }

      .mobile-toggle {
        display: block;
      }

      .content-body {
        padding: 20px 16px;
      }

      .top-header {
        padding: 0 16px;
      }
    }
  </style>

  @stack('styles')
</head>
<body>

<div class="app-container">
  <!-- Mobile Backdrop Overlay -->
  <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

  <!-- ========================================================================
       1. SIDEBAR NAVIGASI
       ======================================================================== -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="brand-icon">E</div>
      <div class="brand-text">
        <h2>Evencraft</h2>
        <span>Event & Workshop System</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      @auth
        <!-- Section: Modul Master Event & Silabus -->
        <div class="nav-section-title">Master Event & Materi</div>

        <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Events</span>
          </div>
          <span class="tag-badge">Utama</span>
        </a>

        <a href="{{ route('event-syllabuses.index') }}" class="nav-item {{ request()->routeIs('event-syllabuses.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <span>Event Syllabuses</span>
          </div>
        </a>

        <!-- Section: Speaker & Narasumber -->
        <div class="nav-section-title">Speaker & Pembicara</div>

        <a href="{{ route('speakers.index') }}" class="nav-item {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Speakers</span>
          </div>
        </a>

        <a href="{{ route('event-speakers.index') }}" class="nav-item {{ request()->routeIs('event-speakers.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M16 16v1a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v1"></path>
              <path d="M18 8h4a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4"></path>
              <circle cx="8" cy="12" r="2"></circle>
            </svg>
            <span>Event Speakers</span>
          </div>
        </a>

        <!-- Section: Tiket & Pricing -->
        <div class="nav-section-title">Tiket & Penjualan</div>

        <a href="{{ route('ticket-tiers.index') }}" class="nav-item {{ request()->routeIs('ticket-tiers.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
              <path d="M13 5v2"></path>
              <path d="M13 17v2"></path>
              <path d="M13 11v2"></path>
            </svg>
            <span>Ticket Tiers</span>
          </div>
        </a>

        <a href="{{ route('ticket-benefits.index') }}" class="nav-item {{ request()->routeIs('ticket-benefits.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>Ticket Benefits</span>
          </div>
        </a>

        <a href="{{ route('ticket-categories.index') }}" class="nav-item {{ request()->routeIs('ticket-categories.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
              <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span>Ticket Categories (Alias)</span>
          </div>
        </a>

        <!-- Section: Peserta & Registrasi -->
        <div class="nav-section-title">Peserta & Registrasi</div>

        <a href="{{ route('attendees.index') }}" class="nav-item {{ request()->routeIs('attendees.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Attendees</span>
          </div>
        </a>

        <a href="{{ route('peserta.index') }}" class="nav-item {{ request()->routeIs('peserta.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
            </svg>
            <span>Peserta (Alias)</span>
          </div>
        </a>

        <a href="{{ route('event-registrations.index') }}" class="nav-item {{ request()->routeIs('event-registrations.*') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <line x1="16" y1="13" x2="8" y2="13"></line>
              <line x1="16" y1="17" x2="8" y2="17"></line>
              <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Event Registrations</span>
          </div>
        </a>
      @else
        <!-- Navigasi Guest (Belum Login) -->
        <div class="nav-section-title">Autentikasi</div>
        <a href="{{ route('login') }}" class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
              <polyline points="10 17 15 12 10 7"></polyline>
              <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
            <span>Masuk / Login</span>
          </div>
        </a>
        <a href="{{ route('register') }}" class="nav-item {{ request()->routeIs('register') ? 'active' : '' }}">
          <div class="nav-item-content">
            <svg viewBox="0 0 24 24">
              <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="8.5" cy="7" r="4"></circle>
              <line x1="20" y1="8" x2="20" y2="14"></line>
              <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <span>Daftar / Register</span>
          </div>
        </a>
      @endauth
    </nav>

    <!-- Sidebar Footer / User Profile Snippet -->
    <div class="sidebar-footer">
      @auth
        <div class="user-snippet">
          <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
          </div>
          <div class="user-info">
            <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
            <div class="user-role">{{ auth()->user()->role ?? 'Member' }}</div>
          </div>
        </div>
      @else
        <div class="user-snippet">
          <div class="user-avatar">?</div>
          <div class="user-info">
            <div class="user-name">Tamu / Guest</div>
            <div class="user-role">Silakan login</div>
          </div>
        </div>
      @endauth
    </div>
  </aside>

  <!-- ========================================================================
       2. MAIN CONTENT WRAPPER
       ======================================================================== -->
  <main class="main-wrapper">
    <!-- Top Header -->
    <header class="top-header">
      <div style="display: flex; align-items: center; gap: 16px;">
        <button class="mobile-toggle" id="mobileToggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
          ☰
        </button>
        <span class="badge-role">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
          </svg>
          Evencraft Management System
        </span>
      </div>

      <div class="header-actions">
        @auth
          <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-danger-outline" style="font-size: 0.8rem; padding: 6px 14px;">
              <svg viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
              </svg>
              <span>Logout</span>
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
          <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        @endauth
      </div>
    </header>

    <!-- Content Body & Flash Notifications -->
    <div class="content-body">
      <!-- Alert: Session Sukses -->
      @if (session('success'))
        <div class="alert alert-success">
          <svg class="alert-icon" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
          <div>
            <strong>Berhasil!</strong> {{ session('success') }}
          </div>
        </div>
      @endif

      <!-- Alert: Session Peringatan/Error -->
      @if (session('error'))
        <div class="alert alert-error">
          <svg class="alert-icon" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <div>
            <strong>Peringatan:</strong> {{ session('error') }}
          </div>
        </div>
      @endif

      <!-- Alert: Error Validasi Input Form -->
      @if ($errors->any())
        <div class="alert alert-warning">
          <svg class="alert-icon" viewBox="0 0 24 24">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
          <div>
            <strong>Terdapat kesalahan pada input Anda:</strong>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif

      <!-- Slot Konten Halaman Spesifik -->
      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <p>&copy; {{ date('Y') }} <strong>Evencraft</strong>. All rights reserved.</p>
      <span>Sistem Pengelolaan Event & Workshop</span>
    </footer>
  </main>
</div>

<!-- ========================================================================
     JAVASCRIPT TOGGLE MOBILE SIDEBAR
     ======================================================================== -->
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    sidebar.classList.toggle('open');
    backdrop.classList.toggle('open');
  }
</script>

@stack('scripts')
</body>
</html>