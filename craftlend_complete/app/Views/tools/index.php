<div class="toolbar">
  <form method="get" class="inline-form ajax-search-form">
    <input type="hidden" name="page" value="tools">
    <input type="text" name="search" placeholder="<?= t('search') ?>" value="<?= e($search ?? '') ?>" id="toolSearchInput">
    <button class="soft-btn" type="submit"><?= t('search') ?></button>
  </form>
  <?php if (has_role(['Admin','Lender','Librarian'])): ?><a class="soft-btn primary" href="<?= base_url('page=tools&action=create') ?>"><?= t('add_tool') ?></a><?php endif; ?>
</div>
<div class="panel">
  <table class="data-table" id="toolsTable">
    <thead><tr><th>ID</th><th><?= t('name') ?></th><th><?= t('category') ?></th><th><?= t('status') ?></th><th>Lender</th><th><?= t('actions') ?></th></tr></thead>
    <tbody>
      <?php foreach ($tools as $tool): ?>
      <tr>
        <td><?= (int)$tool['id'] ?></td>
        <td><?= e($tool['name']) ?></td>
        <td><?= e($tool['category_name']) ?></td>
        <td><span class="badge"><?= e($tool['status']) ?></span></td>
        <td><?= e($tool['lender_name']) ?></td>
        <td class="table-actions">
          <a href="<?= base_url('page=tools&action=show&id=' . (int)$tool['id']) ?>"><?= t('title') ?></a>
          <?php if (has_role(['Admin','Lender','Librarian'])): ?>
          <a href="<?= base_url('page=tools&action=edit&id=' . (int)$tool['id']) ?>"><?= t('edit') ?></a>
          <a href="<?= base_url('page=tools&action=delete&id=' . (int)$tool['id']) ?>" onclick="return confirm('Delete this item?')"><?= t('delete') ?></a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (!$tools): ?><tr><td colspan="6"><?= t('no_data') ?></td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
