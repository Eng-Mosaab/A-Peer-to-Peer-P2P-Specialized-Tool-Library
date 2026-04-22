<div class="panel narrow">
  <h2><?= e($title) ?></h2>
  <form method="post" class="form-grid one">
    <label><span><?= t('name') ?></span><input type="text" name="name" required value="<?= e($user['name'] ?? '') ?>"></label>
    <label><span><?= t('email') ?></span><input type="email" name="email" required value="<?= e($user['email'] ?? '') ?>"></label>
    <label><span><?= t('password') ?> <?= $user ? '(optional)' : '' ?></span><input type="password" name="password" <?= $user ? '' : 'required' ?>></label>
    <label><span><?= t('location') ?></span><input type="text" name="location" value="<?= e($user['location'] ?? '') ?>"></label>
    <label><span><?= t('role') ?></span><select name="role_id"><?php foreach ($roles as $r): ?><option value="<?= (int)$r['id'] ?>" <?= isset($user['role_id']) && (int)$user['role_id']===(int)$r['id'] ? 'selected' : '' ?>><?= e($r['name']) ?></option><?php endforeach; ?></select></label>
    <label><span><?= t('verification_status') ?></span><select name="verification_status"><?php foreach (['Pending','Verified','Rejected'] as $s): ?><option <?= (($user['verification_status'] ?? 'Pending')===$s)?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?></select></label>
    <button class="soft-btn primary" type="submit"><?= t('save') ?></button>
  </form>
</div>
