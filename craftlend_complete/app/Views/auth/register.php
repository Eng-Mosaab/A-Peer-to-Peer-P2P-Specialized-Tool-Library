<div class="panel narrow">
  <h2><?= t('register') ?></h2>
  <form method="post" class="form-grid one">
    <label><span><?= t('name') ?></span><input type="text" name="name" required></label>
    <label><span><?= t('email') ?></span><input type="email" name="email" required></label>
    <label><span><?= t('password') ?></span><input type="password" name="password" required></label>
    <label><span><?= t('location') ?></span><input type="text" name="location"></label>
    <label><span><?= t('role') ?></span>
      <select name="role_id" required>
        <option value="">--</option>
        <?php foreach ($roles as $role): ?><option value="<?= (int)$role['id'] ?>"><?= e($role['name']) ?></option><?php endforeach; ?>
      </select>
    </label>
    <button class="soft-btn primary" type="submit"><?= t('register') ?></button>
  </form>
</div>
