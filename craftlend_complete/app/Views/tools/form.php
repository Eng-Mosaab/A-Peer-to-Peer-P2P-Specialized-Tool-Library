<div class="panel">
  <h2><?= e($title) ?></h2>
  <form method="post" enctype="multipart/form-data" class="form-grid two">
    <label><span><?= t('name') ?></span><input type="text" name="name" required value="<?= e($tool['name'] ?? '') ?>"></label>
    <label><span><?= t('category') ?></span><select name="category_id" required>
      <?php foreach ($categories as $cat): ?><option value="<?= (int)$cat['id'] ?>" <?= isset($tool['category_id']) && (int)$tool['category_id']===(int)$cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option><?php endforeach; ?>
    </select></label>
    <label class="wide"><span><?= t('description') ?></span><textarea name="description" rows="4"><?= e($tool['description'] ?? '') ?></textarea></label>
    <label><span><?= t('condition') ?></span><input type="text" name="tool_condition" value="<?= e($tool['tool_condition'] ?? '') ?>"></label>
    <label><span><?= t('status') ?></span><input type="text" name="status" value="<?= e($tool['status'] ?? 'Available') ?>"></label>
    <label><span><?= t('daily_rate') ?></span><input type="number" step="0.01" name="daily_rate" value="<?= e($tool['daily_rate'] ?? '') ?>"></label>
    <label><span><?= t('deposit_amount') ?></span><input type="number" step="0.01" name="deposit_amount" value="<?= e($tool['deposit_amount'] ?? '') ?>"></label>
    <label><span><?= t('location') ?></span><input type="text" name="location" value="<?= e($tool['location'] ?? '') ?>"></label>
    <label><span><?= t('availability_notes') ?></span><input type="text" name="availability_notes" value="<?= e($tool['availability_notes'] ?? '') ?>"></label>
    <label><span><?= t('image') ?></span><input type="file" name="image" accept="image/*"></label>
    <label><span><?= t('document') ?> (PDF)</span><input type="file" name="document" accept="application/pdf"></label>
    <div class="wide"><button class="soft-btn primary" type="submit"><?= t('save') ?></button></div>
  </form>
</div>
