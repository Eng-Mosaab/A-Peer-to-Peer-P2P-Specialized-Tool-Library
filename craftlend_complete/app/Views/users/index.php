<div class="toolbar split">
  <form method="get" class="inline-form">
    <input type="hidden" name="page" value="users">
    <input type="text" name="search" placeholder="<?= t('search') ?>" value="<?= e($search ?? '') ?>">
    <select name="role_id">
      <option value="0"><?= t('all') ?> <?= t('roles') ?></option>
      <?php foreach ($roles as $r): ?><option value="<?= (int)$r['id'] ?>" <?= ($roleId??0)==(int)$r['id']?'selected':'' ?>><?= e($r['name']) ?></option><?php endforeach; ?>
    </select>
    <button class="soft-btn" type="submit"><?= t('filter') ?></button>
    <a class="soft-btn" href="<?= base_url('page=users') ?>"><?= t('reset') ?></a>
  </form>
  <a class="soft-btn primary" href="<?= base_url('page=users&action=create') ?>">Create User</a>
</div>
<div class="panel">
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('name') ?></th><th><?= t('email') ?></th><th><?= t('role') ?></th><th><?= t('verification_status') ?></th><th><?= t('location') ?></th><th><?= t('actions') ?></th></tr></thead><tbody>
  <?php foreach ($users as $u): ?><tr>
    <td><?= (int)$u['id'] ?></td><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['role_name']) ?></td><td><?= e($u['verification_status']) ?></td><td><?= e($u['location']) ?></td>
    <td class="table-actions"><a href="<?= base_url('page=users&action=edit&id='.(int)$u['id']) ?>"><?= t('edit') ?></a><a href="<?= base_url('page=users&action=delete&id='.(int)$u['id']) ?>" onclick="return confirm('Delete this user?')"><?= t('delete') ?></a></td>
  </tr><?php endforeach; ?>
  <?php if (!$users): ?><tr><td colspan="7"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
