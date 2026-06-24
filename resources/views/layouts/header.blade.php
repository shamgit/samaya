<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>ERP System – Dashboard</title>
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png')}}">
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<!-- CSS Global -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
</head>
<body>


<!-- ════════════════════════════════
     TOP HEADER
════════════════════════════════ -->
<header class="top-header">

  <!-- LEFT: hamburger + logo + separator + back -->
  <div class="header-left">
    <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu">
      <i class="bi bi-list"></i>
    </button>
    <a href="#" class="brand">
      <img src="{{ asset('assets/img/logo.png')}}" style="width:120px;">
    </a>
    <div class="header-sep"></div>
    <a href="#" class="header-back">
      <i class="bi bi-chevron-left"></i>
      <span class="back-txt">Back</span>
    </a>
  </div>

  <div class="header-spacer"></div>

  <!-- RIGHT: messages + notifications + user -->
  <div class="header-right">

    <!-- ── MESSAGE BUTTON ── -->
    <div class="icon-btn" id="msgBtn" title="Messages">
      <i class="bi bi-chat-dots-fill"></i>
      <span class="badge-count">0</span>
      <!-- MESSAGE DROPDOWN -->
      <div class="hdr-dropdown msg-dropdown" id="msgDropdown">
        <div class="dropdown-header">
          <h6>Messages</h6>
          <a href="#">Mark all read</a>
        </div>
        <!-- msg 1 -->
        <div class="msg-item unread">
          <!-- <div class="msg-avatar" style="background:#dbeafe;color:#1e40af;">AR</div>
          <div class="msg-body">
            <div class="msg-name">Arjun R <span class="msg-time">2m ago</span></div>
            <div class="msg-text">PO-2026-0040 is ready for your approval</div>
          </div>
          <div class="msg-unread-dot"></div> -->
        </div>
        <div class="dropdown-footer"><a href="#">View all messages</a></div>
      </div>
    </div>

    <!-- ── NOTIFICATION BUTTON ── -->
    <div class="icon-btn" id="notifBtn" title="Notifications">
      <i class="bi bi-bell-fill"></i>
      <span class="badge-dot"></span>
      <!-- NOTIFICATION DROPDOWN -->
      <div class="hdr-dropdown notif-dropdown" id="notifDropdown">
        <div class="dropdown-header">
          <h6>Notifications</h6>
          <a href="#">Clear all</a>
        </div>
        <!-- <div class="notif-item unread">
          <div class="notif-icon green"><i class="bi bi-check-circle-fill"></i></div>
          <div class="notif-body">
            <div class="notif-title">PO Approved</div>
            <div class="notif-desc">PO-2026-0040 Packaging Material has been approved by manager.</div>
            <div class="notif-time">2 minutes ago</div>
          </div>
        </div>
        <div class="notif-item unread">
          <div class="notif-icon amber"><i class="bi bi-exclamation-triangle-fill"></i></div>
          <div class="notif-body">
            <div class="notif-title">Budget Alert</div>
            <div class="notif-desc">Procurement budget has reached 82% utilisation this month.</div>
            <div class="notif-time">1 hour ago</div>
          </div>
        </div>
        <div class="notif-item unread">
          <div class="notif-icon blue"><i class="bi bi-truck-front-fill"></i></div>
          <div class="notif-body">
            <div class="notif-title">Shipment Update</div>
            <div class="notif-desc">PO-2026-0039 Copper Buttons is now in delivery.</div>
            <div class="notif-time">3 hours ago</div>
          </div>
        </div>
        <div class="notif-item">
          <div class="notif-icon red"><i class="bi bi-x-circle-fill"></i></div>
          <div class="notif-body">
            <div class="notif-title">Request Rejected</div>
            <div class="notif-desc">Material request MR-0078 was rejected. Review comments.</div>
            <div class="notif-time">Yesterday</div>
          </div>
        </div> -->
        <div class="dropdown-footer"><a href="#">View all notifications</a></div>
      </div>
    </div>
    @php
        $name = Auth::user()->name ?? '';
        
        $words = explode(' ', $name);

        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        $initials = substr($initials, 0, 2);
    @endphp

    <!-- ── USER AVATAR BUTTON ── -->
    <div class="avatar-btn" id="userBtn">
      <div class="avatar">{{ $initials }}</div>
      <div class="avatar-info">
        <div class="avatar-name">{{ Auth::user()->name ?? '' }}</div>
        <!-- <div class="avatar-role">Admin</div> -->
      </div>
      <i class="bi bi-chevron-down avatar-chevron"></i>
      <!-- USER DROPDOWN -->
      <div class="hdr-dropdown user-dropdown" id="userDropdown">
        <div class="user-info-block">
          <div class="user-avatar-lg">{{ $initials }}</div>
          <div>
            <div class="user-details-name">{{ Auth::user()->name ?? '' }}</div>
            <!-- <div class="user-details-role">System Administrator</div> -->
          </div>
        </div>
        <a href="{{ route('my_profile', base64_encode(Auth::user()->id)) }}" class="user-menu-item"><i class="bi bi-person"></i> My Profile</a>
        <a href="{{ route('change_password') }}" class="user-menu-item"><i class="bi bi-shield-lock"></i> Change Password</a>
        <div class="user-divider"></div>
         <form method="POST" action="{{ route('logout') }}">
           @csrf
           <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" class="user-menu-item danger"><i class="bi bi-box-arrow-right"></i>  {{ __('Log Out') }}</a>
          </form>
      </div>
    </div>

  </div>
</header>