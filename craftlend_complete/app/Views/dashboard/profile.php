<div class="panel narrow">
  <h2><?= t('profile') ?></h2>
  <div class="profile-list">
    <div><strong><?= t('name') ?>:</strong> <?= e(auth_user()['name']) ?></div>
    <div><strong><?= t('email') ?>:</strong> <?= e(auth_user()['email']) ?></div>
    <div><strong><?= t('role') ?>:</strong> <?= e(auth_user()['role_name']) ?></div>
    <div><strong><?= t('location') ?>:</strong> <?= e(auth_user()['location'] ?? '') ?></div>
    <div><strong>Status:</strong> <?= e(auth_user()['verification_status'] ?? '') ?></div>
  </div>
</div>
