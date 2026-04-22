<div class="cards-4">
  <div class="metric-card"><span>Users</span><strong><?= (int)$stats['users'] ?></strong></div>
  <div class="metric-card"><span>Tools</span><strong><?= (int)$stats['tools'] ?></strong></div>
  <div class="metric-card"><span>Reservations</span><strong><?= (int)$stats['reservations'] ?></strong></div>
  <div class="metric-card"><span>Maintenance</span><strong><?= (int)$stats['maintenance'] ?></strong></div>
</div>
<div class="toolbar split">
  <form method="get" class="inline-form">
    <input type="hidden" name="page" value="reports">
    <select name="type">
      <?php foreach (['summary','users','tools','reservations','maintenance'] as $opt): ?><option value="<?= $opt ?>" <?= ($type ?? 'summary')===$opt?'selected':'' ?>><?= ucfirst($opt) ?></option><?php endforeach; ?>
    </select>
    <input type="text" name="search" placeholder="<?= t('search') ?>" value="<?= e($search ?? '') ?>">
    <input type="text" name="status" placeholder="<?= t('status') ?>" value="<?= e($status ?? '') ?>">
    <button class="soft-btn" type="submit"><?= t('filter') ?></button>
    <a class="soft-btn" href="<?= base_url('page=reports') ?>"><?= t('reset') ?></a>
  </form>
  <a class="soft-btn primary" href="<?= base_url('page=reports&action=export&type=' . urlencode($type ?? 'summary') . '&search=' . urlencode($search ?? '') . '&status=' . urlencode($status ?? '')) ?>"><?= t('export_csv') ?></a>
</div>
<div class="panel">
  <?php if (($type ?? 'summary') === 'summary'): ?>
    <p>This page shows a simple summary. You can switch the type to users, tools, reservations, or maintenance, then export the result as CSV.</p>
    <button class="soft-btn" onclick="window.print()">Print / Save PDF</button>
  <?php else: ?>
    <table class="data-table">
      <thead><tr><?php if (!empty($rows)): ?><?php foreach (array_keys($rows[0]) as $key): ?><th><?= e(ucwords(str_replace('_',' ',$key))) ?></th><?php endforeach; ?><?php else: ?><th><?= t('title') ?></th><?php endif; ?></tr></thead>
      <tbody>
        <?php foreach ($rows as $row): ?><tr><?php foreach ($row as $cell): ?><td><?= e((string)$cell) ?></td><?php endforeach; ?></tr><?php endforeach; ?>
        <?php if (!$rows): ?><tr><td><?= t('no_data') ?></td></tr><?php endif; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
