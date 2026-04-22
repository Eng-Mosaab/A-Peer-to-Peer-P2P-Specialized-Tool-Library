<?php $adminLike = has_role(['Admin','Librarian']); ?>
<?php if ($adminLike): ?>
<div class="two-col">
  <div class="panel">
    <h3><?= t('send_notification') ?></h3>
    <form method="post" action="<?= base_url('page=notifications&action=create') ?>" class="form-grid one">
      <label><span>Target Type</span><select name="target_type"><option value="user">User</option><option value="role">Role</option></select></label>
      <label><span>User</span><select name="user_id"><?php foreach ($users as $u): ?><option value="<?= (int)$u['id'] ?>"><?= e($u['name']) ?> (<?= e($u['role_name']) ?>)</option><?php endforeach; ?></select></label>
      <label><span><?= t('role') ?></span><select name="role_id"><?php foreach ($roles as $r): ?><option value="<?= (int)$r['id'] ?>"><?= e($r['name']) ?></option><?php endforeach; ?></select></label>
      <label><span><?= t('title') ?></span><input type="text" name="title" required></label>
      <label><span><?= t('message') ?></span><textarea name="message" rows="4" required></textarea></label>
      <button class="soft-btn primary" type="submit"><?= t('send') ?></button>
    </form>
  </div>
  <div class="panel">
    <h3><?= t('send_email') ?></h3>
    <form method="post" action="<?= base_url('page=notifications&action=sendEmail') ?>" class="form-grid one">
      <label><span><?= t('recipient') ?></span><input type="email" name="recipient_email" required></label>
      <label><span><?= t('subject') ?></span><input type="text" name="subject" required></label>
      <label><span><?= t('message') ?></span><textarea name="message" rows="4" required></textarea></label>
      <button class="soft-btn primary" type="submit"><?= t('send') ?></button>
    </form>
  </div>
</div>
<?php endif; ?>
<div class="panel">
  <h3><?= t('notifications') ?></h3>
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('title') ?></th><th><?= t('message') ?></th><th><?= t('status') ?></th><th><?= t('recipient') ?></th><th><?= t('actions') ?></th></tr></thead><tbody>
  <?php foreach ($items as $n): ?><tr data-id="<?= (int)$n['id'] ?>">
    <td><?= (int)$n['id'] ?></td><td><?= e($n['title']) ?></td><td><?= e($n['message']) ?></td><td><?= (int)$n['is_read'] ? 'Read' : 'Unread' ?></td><td><?= e($n['user_name'] ?? (auth_user()['name'] ?? '')) ?></td>
    <td><?php if (!(int)$n['is_read'] && !has_role('Admin')): ?><button class="soft-btn mark-read-btn" data-id="<?= (int)$n['id'] ?>"><?= t('mark_read') ?></button><?php endif; ?></td>
  </tr><?php endforeach; ?>
  <?php if (!$items): ?><tr><td colspan="6"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
<?php if ($adminLike): ?>
<div class="panel">
  <h3><?= t('email_logs') ?></h3>
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('recipient') ?></th><th><?= t('subject') ?></th><th><?= t('created_at') ?></th></tr></thead><tbody>
  <?php foreach ($emailLogs as $row): ?><tr><td><?= (int)$row['id'] ?></td><td><?= e($row['recipient_email']) ?></td><td><?= e($row['subject']) ?></td><td><?= e($row['created_at']) ?></td></tr><?php endforeach; ?>
  <?php if (!$emailLogs): ?><tr><td colspan="4"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
<?php endif; ?>
