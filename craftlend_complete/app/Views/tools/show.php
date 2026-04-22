<div class="panel">
  <div class="detail-head">
    <div>
      <h2><?= e($tool['name']) ?></h2>
      <p><?= e($tool['category_name']) ?> · <?= e($tool['status']) ?></p>
    </div>
    <?php if ($tool['image_path']): ?><img src="<?= e(uploaded_url($tool['image_path'])) ?>" alt="tool" class="detail-image"><?php endif; ?>
  </div>
  <div class="details-grid">
    <div><strong><?= t('description') ?>:</strong> <?= e($tool['description']) ?></div>
    <div><strong><?= t('condition') ?>:</strong> <?= e($tool['tool_condition']) ?></div>
    <div><strong><?= t('daily_rate') ?>:</strong> <?= e($tool['daily_rate']) ?></div>
    <div><strong><?= t('deposit_amount') ?>:</strong> <?= e($tool['deposit_amount']) ?></div>
    <div><strong><?= t('location') ?>:</strong> <?= e($tool['location']) ?></div>
    <div><strong>Lender:</strong> <?= e($tool['lender_name']) ?></div>
    <div class="wide"><strong><?= t('availability_notes') ?>:</strong> <?= e($tool['availability_notes']) ?></div>
    <?php if ($tool['document_path']): ?><div class="wide"><a class="soft-btn" target="_blank" href="<?= e(uploaded_url($tool['document_path'])) ?>">Open PDF</a></div><?php endif; ?>
  </div>
</div>
