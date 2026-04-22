<?php $page = $_GET['page'] ?? 'home'; $user = auth_user(); $dir = current_lang()==='ar' ? 'rtl' : 'ltr'; ?>
<!doctype html>
<html lang="<?= e(current_lang()) ?>" dir="<?= $dir ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e(($title ?? '') . ' - ' . t('app_name')) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-<?= e(current_theme()) ?> <?= $dir ?>">
<div class="app-shell">
  <aside class="sidebar">
    <div class="brand">
      <img src="assets/logo/craftlend-logo.svg" alt="logo" class="logo">
      <div>
        <h1><?= t('app_name') ?></h1>
        <p><?= t('tagline') ?></p>
      </div>
    </div>
    <nav class="menu">
      <?php foreach (nav_for_role($user['role_name'] ?? null) as $item): ?>
        <a class="menu-link <?= str_contains($item['q'], 'page=' . $page) ? 'active' : '' ?>" href="<?= base_url($item['q']) ?>"><?= e($item['label']) ?></a>
      <?php endforeach; ?>
    </nav>
  </aside>
  <main class="main">
    <header class="topbar">
      <div>
        <strong><?= e($title ?? t('app_name')) ?></strong>
      </div>
      <div class="top-actions">
        <a class="soft-btn" href="<?= base_url('page=lang&action=switch&lang=' . (current_lang()==='en' ? 'ar' : 'en')) ?>"><?= t('lang_toggle') ?></a>
        <a class="soft-btn" href="<?= base_url('page=theme&action=switch&theme=' . (current_theme()==='light' ? 'dark' : 'light')) ?>"><?= current_theme()==='light' ? t('dark_mode') : t('light_mode') ?></a>
        <?php if ($user): ?>
          <span class="user-chip"><?= e($user['name']) ?> · <?= e($user['role_name']) ?></span>
          <a class="soft-btn danger" href="<?= base_url('page=auth&action=logout') ?>"><?= t('logout') ?></a>
        <?php else: ?>
          <a class="soft-btn" href="<?= base_url('page=auth&action=login') ?>"><?= t('login') ?></a>
          <a class="soft-btn primary" href="<?= base_url('page=auth&action=register') ?>"><?= t('register') ?></a>
        <?php endif; ?>
      </div>
    </header>
    <section class="content">
      <?php if ($msg = flash('success')): ?><div class="alert success"><?= e($msg) ?></div><?php endif; ?>
      <?php if ($msg = flash('error')): ?><div class="alert error"><?= e($msg) ?></div><?php endif; ?>
