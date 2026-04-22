<div class="toolbar split">
  <form method="get" class="inline-form">
    <input type="hidden" name="page" value="roles">
    <input type="text" name="search" placeholder="<?= t('search') ?>" value="<?= e($search ?? '') ?>">
    <button class="soft-btn" type="submit"><?= t('filter') ?></button>
    <a class="soft-btn" href="<?= base_url('page=roles') ?>"><?= t('reset') ?></a>
  </form>
  <a class="soft-btn primary" href="<?= base_url('page=roles&action=create') ?>"><?= t('new_role') ?></a>
</div>
<div class="panel">
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('name') ?></th><th><?= t('actions') ?></th></tr></thead><tbody>
  <?php foreach ($roles as $r): ?><tr>
    <td><?= (int)$r['id'] ?></td><td><?= e($r['name']) ?></td>
    <td class="table-actions"><a href="<?= base_url('page=roles&action=edit&id='.(int)$r['id']) ?>"><?= t('edit') ?></a><a href="<?= base_url('page=roles&action=delete&id='.(int)$r['id']) ?>" onclick="return confirm('Delete this role?')"><?= t('delete') ?></a></td>
  </tr><?php endforeach; ?>
  <?php if (!$roles): ?><tr><td colspan="3"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
