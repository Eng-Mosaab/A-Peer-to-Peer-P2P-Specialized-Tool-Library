<div class="panel">
  <h2><?= e($title) ?></h2>
  <form method="post" enctype="multipart/form-data" class="form-grid two">
    <label><span>Tool</span><select name="tool_id" <?= $request ? 'disabled' : '' ?>><?php foreach ($tools as $t): ?><option value="<?= (int)$t['id'] ?>" <?= isset($request['tool_id']) && (int)$request['tool_id']===(int)$t['id'] ? 'selected' : '' ?>><?= e($t['name']) ?></option><?php endforeach; ?></select></label>
    <?php if ($request): ?><input type="hidden" name="tool_id" value="<?= (int)$request['tool_id'] ?>"><?php endif; ?>
    <label><span><?= t('title') ?></span><input type="text" name="title" required value="<?= e($request['title'] ?? '') ?>"></label>
    <label class="wide"><span><?= t('description') ?></span><textarea name="description" rows="4"><?= e($request['description'] ?? '') ?></textarea></label>
    <label><span>Priority</span><select name="priority"><?php foreach (['Low','Medium','High'] as $p): ?><option <?= (($request['priority'] ?? 'Medium')===$p)?'selected':'' ?>><?= e($p) ?></option><?php endforeach; ?></select></label>
    <label><span><?= t('status') ?></span><select name="status"><?php foreach (['Open','In Progress','Closed'] as $s): ?><option <?= (($request['status'] ?? 'Open')===$s)?'selected':'' ?>><?= e($s) ?></option><?php endforeach; ?></select></label>
    <label><span>Evidence</span><input type="file" name="evidence" accept="image/*,application/pdf"></label>
    <div class="wide"><button class="soft-btn primary" type="submit"><?= t('save') ?></button></div>
  </form>
</div>
