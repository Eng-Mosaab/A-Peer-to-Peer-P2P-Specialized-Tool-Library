<div class="panel narrow">
  <h2><?= e($title) ?></h2>
  <form method="post" class="form-grid one">
    <label><span><?= t('tool') ?></span><select name="tool_id" <?= $reservation ? 'disabled' : '' ?>><?php foreach ($tools as $t): ?><option value="<?= (int)$t['id'] ?>" <?= isset($reservation['tool_id']) && (int)$reservation['tool_id']===(int)$t['id'] ? 'selected' : '' ?>><?= e($t['name']) ?></option><?php endforeach; ?></select></label>
    <?php if ($reservation): ?><input type="hidden" name="tool_id" value="<?= (int)$reservation['tool_id'] ?>"><?php endif; ?>
    <label><span><?= t('start_date') ?></span><input type="date" name="start_date" required value="<?= e($reservation['start_date'] ?? '') ?>"></label>
    <label><span><?= t('end_date') ?></span><input type="date" name="end_date" required value="<?= e($reservation['end_date'] ?? '') ?>"></label>
    <?php if (($mode ?? 'create') !== 'create'): ?>
      <label><span><?= t('status') ?></span><select name="status"><?php foreach (['Pending','Approved','Rescheduled','Rejected','Cancelled','Returned'] as $s): ?><option <?= (($reservation['status'] ?? 'Pending')===$s)?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?></select></label>
    <?php endif; ?>
    <label><span><?= t('notes') ?></span><textarea name="notes" rows="4"><?= e($reservation['notes'] ?? '') ?></textarea></label>
    <button class="soft-btn primary" type="submit"><?= t('save') ?></button>
  </form>
</div>
