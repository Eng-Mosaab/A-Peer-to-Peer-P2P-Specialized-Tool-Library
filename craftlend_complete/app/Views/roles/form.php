<div class="panel narrow">
  <h2><?= e($title) ?></h2>
  <form method="post" class="form-grid one">
    <label><span><?= t('name') ?></span><input type="text" name="name" required value="<?= e($role['name'] ?? '') ?>"></label>
    <button class="soft-btn primary" type="submit"><?= t('save') ?></button>
  </form>
</div>
