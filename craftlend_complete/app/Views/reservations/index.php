<div class="toolbar split">
  <form method="get" class="inline-form">
    <input type="hidden" name="page" value="reservations">
    <select name="status">
      <option value=""><?= t('all') ?> <?= t('status') ?></option>
      <?php foreach (['Pending','Approved','Rescheduled','Rejected','Cancelled','Returned'] as $s): ?><option value="<?= e($s) ?>" <?= ($statusFilter ?? '')===$s?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?>
    </select>
    <button class="soft-btn" type="submit"><?= t('filter') ?></button>
    <a class="soft-btn" href="<?= base_url('page=reservations') ?>"><?= t('reset') ?></a>
  </form>
  <a class="soft-btn primary" href="<?= base_url('page=reservations&action=create') ?>"><?= t('new_reservation') ?></a>
</div>
<div class="panel">
  <table class="data-table"><thead><tr><th>ID</th><th><?= t('tool') ?></th><th><?= t('borrower') ?></th><th><?= t('start_date') ?></th><th><?= t('end_date') ?></th><th><?= t('status') ?></th><th><?= t('actions') ?></th></tr></thead><tbody>
  <?php foreach ($reservations as $r): ?><tr>
    <td><?= (int)$r['id'] ?></td><td><?= e($r['tool_name']) ?></td><td><?= e($r['borrower_name']) ?></td><td><?= e($r['start_date']) ?></td><td><?= e($r['end_date']) ?></td><td><span class="badge"><?= e($r['status']) ?></span></td>
    <td class="table-actions">
      <a href="<?= base_url('page=reservations&action=edit&id='.(int)$r['id']) ?>"><?= t('edit') ?></a>
      <a href="<?= base_url('page=reservations&action=reschedule&id='.(int)$r['id']) ?>"><?= t('reschedule') ?></a>
      <?php if (has_role(['Admin','Librarian','Lender'])): ?>
        <a href="<?= base_url('page=reservations&action=approve&id='.(int)$r['id']) ?>"><?= t('approve') ?></a>
        <a href="<?= base_url('page=reservations&action=reject&id='.(int)$r['id']) ?>"><?= t('reject') ?></a>
      <?php endif; ?>
      <a href="<?= base_url('page=reservations&action=cancel&id='.(int)$r['id']) ?>"><?= t('cancel') ?></a>
      <a href="<?= base_url('page=reservations&action=returnTool&id='.(int)$r['id']) ?>"><?= t('return_tool') ?></a>
      <?php if (has_role(['Admin','Librarian'])): ?><a href="<?= base_url('page=reservations&action=delete&id='.(int)$r['id']) ?>" onclick="return confirm('Delete this reservation?')"><?= t('delete') ?></a><?php endif; ?>
    </td>
  </tr><?php endforeach; ?>
  <?php if (!$reservations): ?><tr><td colspan="7"><?= t('no_data') ?></td></tr><?php endif; ?>
  </tbody></table>
</div>
