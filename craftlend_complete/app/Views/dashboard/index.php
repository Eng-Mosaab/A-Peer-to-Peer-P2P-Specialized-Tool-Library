<div class="cards-4">
  <div class="metric-card"><span>Total Tools</span><strong><?= (int)$stats['tools'] ?></strong></div>
  <div class="metric-card"><span>Active Reservations</span><strong><?= (int)$stats['activeReservations'] ?></strong></div>
  <div class="metric-card"><span>Open Maintenance</span><strong><?= (int)$stats['openMaintenance'] ?></strong></div>
  <div class="metric-card"><span>Unread Notifications</span><strong><?= (int)$stats['unreadNotifications'] ?></strong></div>
</div>
<div class="two-col">
  <div class="panel">
    <h3><?= t('welcome') ?>, <?= e(auth_user()['name']) ?></h3>
    <p>You are logged in as <strong><?= e(auth_user()['role_name']) ?></strong>.</p>
    <p>Use the sidebar to move between tools, reservations, maintenance, users, and reports.</p>
  </div>
  <div class="panel">
    <h3>Quick links</h3>
    <div class="quick-links">
      <a href="<?= base_url('page=tools') ?>">Open Tools</a>
      <a href="<?= base_url('page=reservations') ?>">Open Reservations</a>
      <a href="<?= base_url('page=maintenance') ?>">Open Maintenance</a>
      <a href="<?= base_url('page=notifications') ?>">Open Notifications</a>
    </div>
  </div>
</div>
<?php if ($roleCounts): ?>
<div class="panel">
  <h3>Users by role</h3>
  <table class="data-table"><thead><tr><th>Role</th><th>Total</th></tr></thead><tbody>
    <?php foreach ($roleCounts as $row): ?><tr><td><?= e($row['name']) ?></td><td><?= (int)$row['total'] ?></td></tr><?php endforeach; ?>
  </tbody></table>
</div>
<?php endif; ?>
