<div class="hero-grid">
  <div class="hero-card big">
    <p class="eyebrow">CraftLend</p>
    <h2><?= t('welcome_title') ?></h2>
    <p><?= t('welcome_text') ?></p>
    <div class="hero-actions">
      <a class="soft-btn primary" href="<?= base_url('page=auth&action=register') ?>"><?= t('get_started') ?></a>
      <a class="soft-btn" href="<?= base_url('page=auth&action=login') ?>"><?= t('login') ?></a>
    </div>
  </div>
  <div class="hero-card stats">
    <div class="stat-box"><span>Admin</span><strong>Manage users, reports, and platform settings.</strong></div>
    <div class="stat-box"><span>Librarian</span><strong>Review tools, monitor reservations, and handle issues.</strong></div>
    <div class="stat-box"><span>Borrower / Lender</span><strong>Reserve tools, list tools, and manage documents.</strong></div>
    <div class="stat-box"><span>Technician</span><strong>Track maintenance work and update repair status.</strong></div>
  </div>
</div>
