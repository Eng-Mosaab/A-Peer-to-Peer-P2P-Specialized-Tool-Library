<?php

function app_config(): array
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/Config/config.php';
    }
    return $config;
}

function base_url(string $query = ''): string
{
    $base = app_config()['base_url'];
    return $query ? $base . '?' . ltrim($query, '?') : $base;
}

function current_lang(): string { return $_SESSION['lang'] ?? 'en'; }
function current_theme(): string { return $_SESSION['theme'] ?? 'light'; }

function translations(): array
{
    return [
        'en' => [
            'app_name'=>'CraftLend','tagline'=>'Tool rental and management platform','home'=>'Home','login'=>'Login','register'=>'Register','logout'=>'Logout',
            'dashboard'=>'Dashboard','tools'=>'Tools','users'=>'Users','roles'=>'Roles','reservations'=>'Reservations','maintenance'=>'Maintenance',
            'notifications'=>'Notifications','reports'=>'Reports','emails'=>'Emails','categories'=>'Categories','welcome_title'=>'Manage tool rental in one clear system',
            'welcome_text'=>'CraftLend helps admins, librarians, borrowers, lenders, and technicians work together in one place.','get_started'=>'Get Started',
            'email'=>'Email','password'=>'Password','name'=>'Name','role'=>'Role','save'=>'Save','create'=>'Create','edit'=>'Edit','delete'=>'Delete',
            'search'=>'Search','status'=>'Status','actions'=>'Actions','title'=>'Title','description'=>'Description','category'=>'Category','daily_rate'=>'Daily Rate',
            'deposit_amount'=>'Deposit Amount','image'=>'Image','document'=>'Document','submit'=>'Submit','start_date'=>'Start Date','end_date'=>'End Date','notes'=>'Notes',
            'light_mode'=>'Light','dark_mode'=>'Dark','lang_toggle'=>'AR','theme_toggle'=>'Theme','no_data'=>'No data yet.','profile'=>'Profile','location'=>'Location',
            'availability_notes'=>'Availability Notes','condition'=>'Condition','add_tool'=>'Add Tool','new_reservation'=>'New Reservation','new_request'=>'New Request',
            'mark_read'=>'Mark as read','welcome'=>'Welcome','language'=>'Language','filter'=>'Filter','all'=>'All','reset'=>'Reset','priority'=>'Priority',
            'borrower'=>'Borrower','lender'=>'Lender','tool'=>'Tool','return_tool'=>'Return Tool','cancel'=>'Cancel','approve'=>'Approve','reject'=>'Reject','reschedule'=>'Reschedule',
            'send'=>'Send','message'=>'Message','subject'=>'Subject','recipient'=>'Recipient','export_csv'=>'Export CSV','verification_status'=>'Verification Status',
            'new_role'=>'New Role','send_notification'=>'Send Notification','send_email'=>'Send Email','email_logs'=>'Email Logs','created_at'=>'Created At'
        ],
        'ar' => [
            'app_name'=>'كرافت ليند','tagline'=>'منصة لتأجير وإدارة الأدوات','home'=>'الرئيسية','login'=>'تسجيل الدخول','register'=>'إنشاء حساب','logout'=>'تسجيل الخروج',
            'dashboard'=>'لوحة التحكم','tools'=>'الأدوات','users'=>'المستخدمون','roles'=>'الأدوار','reservations'=>'الحجوزات','maintenance'=>'الصيانة','notifications'=>'الإشعارات',
            'reports'=>'التقارير','emails'=>'الرسائل','categories'=>'الفئات','welcome_title'=>'إدارة تأجير الأدوات في نظام واحد واضح',
            'welcome_text'=>'كرافت ليند يساعد الأدمن والليبريان والمستعير والمالك والفني على العمل معًا في مكان واحد.','get_started'=>'ابدأ','email'=>'البريد الإلكتروني',
            'password'=>'كلمة المرور','name'=>'الاسم','role'=>'الدور','save'=>'حفظ','create'=>'إنشاء','edit'=>'تعديل','delete'=>'حذف','search'=>'بحث','status'=>'الحالة',
            'actions'=>'الإجراءات','title'=>'العنوان','description'=>'الوصف','category'=>'الفئة','daily_rate'=>'السعر اليومي','deposit_amount'=>'قيمة التأمين','image'=>'صورة',
            'document'=>'ملف','submit'=>'إرسال','start_date'=>'تاريخ البداية','end_date'=>'تاريخ النهاية','notes'=>'ملاحظات','light_mode'=>'نهاري','dark_mode'=>'ليلي',
            'lang_toggle'=>'EN','theme_toggle'=>'الوضع','no_data'=>'لا توجد بيانات بعد.','profile'=>'الملف الشخصي','location'=>'الموقع','availability_notes'=>'ملاحظات التوفر',
            'condition'=>'الحالة','add_tool'=>'إضافة أداة','new_reservation'=>'حجز جديد','new_request'=>'طلب جديد','mark_read'=>'تعليم كمقروء','welcome'=>'أهلاً','language'=>'اللغة',
            'filter'=>'فلترة','all'=>'الكل','reset'=>'إعادة ضبط','priority'=>'الأولوية','borrower'=>'المستعير','lender'=>'المالك','tool'=>'الأداة','return_tool'=>'إرجاع الأداة',
            'cancel'=>'إلغاء','approve'=>'قبول','reject'=>'رفض','reschedule'=>'إعادة جدولة','send'=>'إرسال','message'=>'الرسالة','subject'=>'الموضوع','recipient'=>'المستلم',
            'export_csv'=>'تصدير CSV','verification_status'=>'حالة التحقق','new_role'=>'دور جديد','send_notification'=>'إرسال إشعار','send_email'=>'إرسال بريد','email_logs'=>'سجل الرسائل',
            'created_at'=>'تاريخ الإنشاء'
        ],
    ];
}

function t(string $key): string { $lang=current_lang(); $map=translations(); return $map[$lang][$key] ?? ($map['en'][$key] ?? $key); }
function is_logged_in(): bool { return !empty($_SESSION['user']); }
function auth_user(): ?array { return $_SESSION['user'] ?? null; }
function has_role(string|array $roles): bool { return is_logged_in() && in_array(auth_user()['role_name'] ?? '', (array)$roles, true); }
function require_auth(): void { if (!is_logged_in()) { header('Location: '.base_url('page=auth&action=login')); exit; } }
function require_role(string|array $roles): void { require_auth(); if (!has_role($roles)) { http_response_code(403); die('Forbidden'); } }
function flash(string $key, ?string $message = null): ?string { if ($message !== null) { $_SESSION['_flash'][$key] = $message; return null; } $v=$_SESSION['_flash'][$key] ?? null; unset($_SESSION['_flash'][$key]); return $v; }
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function is_post(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function uploaded_url(?string $path): ?string { return $path ? 'uploads/' . ltrim($path, '/') : null; }

function nav_for_role(?string $role): array
{
    $common = [
        ['label' => t('dashboard'), 'q' => 'page=dashboard'],
        ['label' => t('tools'), 'q' => 'page=tools'],
        ['label' => t('reservations'), 'q' => 'page=reservations'],
        ['label' => t('maintenance'), 'q' => 'page=maintenance'],
        ['label' => t('notifications'), 'q' => 'page=notifications'],
        ['label' => t('profile'), 'q' => 'page=dashboard&action=profile'],
    ];
    return match ($role) {
        'Admin' => array_merge($common, [
            ['label' => t('users'), 'q' => 'page=users'],
            ['label' => t('roles'), 'q' => 'page=roles'],
            ['label' => t('reports'), 'q' => 'page=reports'],
        ]),
        'Librarian' => array_merge($common, [
            ['label' => t('reports'), 'q' => 'page=reports'],
        ]),
        'Technician' => array_merge($common, [
            ['label' => t('reports'), 'q' => 'page=reports'],
        ]),
        'Borrower', 'Lender' => $common,
        default => [['label' => t('home'), 'q' => 'page=home']],
    };
}
