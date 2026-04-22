<div class="toolbar"><a class="soft-btn primary" href="<?= base_url('page=maintenance&action=create') ?>"><?= t('new_request') ?></a></div>
<div class="panel">
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('title') ?></th><th>Tool</th><th>Priority</th><th><?= t('status') ?></th><th><?= t('actions') ?></th></tr></thead><tbody>
  <?php foreach ($requests as $r): ?><tr>
    <td><?= (int)$r['id'] ?></td><td><?= e($r['title']) ?></td><td><?= e($r['tool_name']) ?></td><td><?= e($r['priority']) ?></td><td><?= e($r['status']) ?></td>
    <td class="table-actions"><a href="<?= base_url('page=maintenance&action=edit&id='.(int)$r['id']) ?>"><?= t('edit') ?></a></td>
  </tr><?php endforeach; ?>
  <?php if (!$requests): ?><tr><td colspan="6"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
