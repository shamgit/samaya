<!-- MOBILE BOTTOM NAV -->
<nav class="bottom-nav d-none" id="bottomNav">
  <a href="#" class="bottom-nav-item active" data-bottom><i class="bi bi-grid-fill"></i><span>Dashboard</span></a>
  <a href="#" class="bottom-nav-item" data-bottom><i class="bi bi-bag-fill"></i><span>Procure</span></a>
  <a href="#" class="bottom-nav-item" data-bottom><i class="bi bi-bar-chart-fill"></i><span>Finance</span></a>
  <a href="#" class="bottom-nav-item" data-bottom><i class="bi bi-bell"></i><span>Alerts</span></a>
  <a href="#" class="bottom-nav-item" id="moreBtn" data-bottom><i class="bi bi-list"></i><span>More</span></a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.nav-item-parent').forEach(parent => {
    parent.addEventListener('click', () => {
        const submenuId = parent.id.replace('parent-', 'submenu-');
        const submenu = document.getElementById(submenuId);
        const isOpen = submenu.classList.contains('open');

        // Close all other submenus
        document.querySelectorAll('.nav-submenu').forEach(sm => sm.classList.remove('open'));
        document.querySelectorAll('.nav-item-parent').forEach(p => {
            p.classList.remove('open');
            p.querySelector('.nav-label')?.classList.remove('active');
        });

        // Open current if it wasn't open
        if (!isOpen && submenu) {
            parent.classList.add('open');
            submenu.classList.add('open');
            parent.querySelector('.nav-label')?.classList.add('active');
        }
    });
});
</script>
<script>

document.querySelectorAll('.nav-sub-item').forEach(item => {

    item.addEventListener('click', function () {

        // Remove active class from all
        document.querySelectorAll('.nav-sub-item').forEach(el => {
            el.classList.remove('active');
        });

        // Add active class
        this.classList.add('active');

        // Scroll active item into view
        this.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'nearest'
        });

    });

});

</script>
<script>
/* ── DROPDOWN MANAGER ── */
const dropdowns = [
  { btn: 'msgBtn',   panel: 'msgDropdown' },
  { btn: 'notifBtn', panel: 'notifDropdown' },
  { btn: 'userBtn',  panel: 'userDropdown' },
];

function closeAllDropdowns(except) {
  dropdowns.forEach(d => {
    if (d.btn === except) return;
    document.getElementById(d.btn).classList.remove('active');
    document.getElementById(d.panel).classList.remove('open');
  });
  document.getElementById('userBtn')?.classList.remove('active');
}

dropdowns.forEach(({ btn, panel }) => {
  const btnEl   = document.getElementById(btn);
  const panelEl = document.getElementById(panel);
  btnEl.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = panelEl.classList.contains('open');
    closeAllDropdowns(btn);
    if (!isOpen) {
      panelEl.classList.add('open');
      btnEl.classList.add('active');
    } else {
      panelEl.classList.remove('open');
      btnEl.classList.remove('active');
    }
  });
  panelEl.addEventListener('click', e => e.stopPropagation());
});

// Close on outside click
document.addEventListener('click', () => closeAllDropdowns(null));

// Mark messages read on click
document.querySelectorAll('.msg-item, .notif-item').forEach(item => {
  item.addEventListener('click', () => item.classList.remove('unread'));
});

/* ── SIDEBAR ── */
const sidebar         = document.getElementById('sidebar');
const overlay         = document.getElementById('sidebarOverlay');
const hamburgerBtn    = document.getElementById('hamburgerBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');

function openSidebar()  { sidebar.classList.add('drawer-open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeSidebar() { sidebar.classList.remove('drawer-open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

hamburgerBtn.addEventListener('click', openSidebar);
closeSidebarBtn.addEventListener('click', closeSidebar);
overlay.addEventListener('click', closeSidebar);
document.getElementById('moreBtn').addEventListener('click', e => { e.preventDefault(); openSidebar(); });

document.querySelectorAll('[data-nav]').forEach(item => {
  item.addEventListener('click', function(e) {
    if (this.classList.contains('nav-logout')) return;
    e.preventDefault();
    document.querySelectorAll('[data-nav]').forEach(n => n.classList.remove('active'));
    this.classList.add('active');
    if (window.innerWidth < 992) closeSidebar();
  });
});

/* ── SUBMENU ACCORDION ── */
const submenus = [
  // { parent: 'procurementParent', menu: 'procurementSubmenu' },
  // { parent: 'materialParent',    menu: 'materialSubmenu'    },
  // { parent: 'hrParent',          menu: 'hrSubmenu'          },
  // { parent: 'salesParent',       menu: 'salesSubmenu' },
  // { parent: 'logisticsParent',   menu: 'logisticsSubmenu'},
  // { parent: 'masterParent',   menu: 'masterSubmenu'},
];



submenus.forEach(({ parent, menu }) => {
  const parentEl = document.getElementById(parent);
  const menuEl   = document.getElementById(menu);

  parentEl.addEventListener('click', () => {
    const isOpen = menuEl.classList.contains('open');

    // Close all submenus (accordion behaviour)
    submenus.forEach(({ parent: p, menu: m }) => {
      document.getElementById(p).classList.remove('open');
      document.getElementById(m).classList.remove('open');
    });

    // Re-open if it wasn't open before
    if (!isOpen) {
      parentEl.classList.add('open');
      menuEl.classList.add('open');
    }

    // Mark parent active
    document.querySelectorAll('.nav-item-parent').forEach(n => n.classList.remove('active'));
    if (!isOpen) parentEl.classList.add('active');
  });
});

/* Sub-item active state */
document.querySelectorAll('[data-subnav]').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelectorAll('[data-subnav]').forEach(n => n.classList.remove('active'));
    this.classList.add('active');
    if (window.innerWidth < 992) closeSidebar();
  });
});

document.querySelectorAll('[data-bottom]').forEach(item => {
  item.addEventListener('click', function(e) {
    if (this.id === 'moreBtn') return;
    e.preventDefault();
    document.querySelectorAll('[data-bottom]').forEach(n => n.classList.remove('active'));
    this.classList.add('active');
  });
});

/* ── SWIPE TO CLOSE ── */
let tX = 0;
sidebar.addEventListener('touchstart', e => { tX = e.touches[0].clientX; }, { passive: true });
sidebar.addEventListener('touchmove',  e => { if (e.touches[0].clientX - tX < -60) closeSidebar(); }, { passive: true });

/* ── ANIMATE PROGRESS BARS ── */
const barObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { setTimeout(() => { e.target.style.width = e.target.dataset.width; }, 200); barObs.unobserve(e.target); }
  });
}, { threshold: 0.3 });
document.querySelectorAll('.progress-bar[data-width]').forEach(b => barObs.observe(b));
</script>
</body>
</html>