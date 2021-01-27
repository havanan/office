<?php

define('PER_PAGE_MAX', 9999);
define('PER_PAGE', 10);
define('CURRENT_PAGE', 1);

define('CUSTOMER_STATUS', [
    0 => 'Đang khóa',
    1 => 'Đã kích hoạt'
]);
define('CUSTOMER_ACTIVE', 1);

define('CATEGORY_STATUS', [
    0 => 'Đang khóa',
    1 => 'Đã kích hoạt'
]);
define('CATEGORY_STATUS_LOCK', '');
define('CATEGORY_STATUS_ACTIVE', '1');
//news
define('NEWS_UN_PUBLIC', 0);
define('NEWS_PUBLIC', 1);

define('NEWS_PUBLIC_STATUS', [
    0 => 'Ẩn',
    1 => 'Hiển thị'
]);
//Các Key của REDIS
define('REDIS_COMMENT_CHANNEL', 'comment-channel');
define('REDIS_NOTIFY_CHANNEL', 'notify-channel');


define('RAKU_CUSTOMER_ID', 1);

//Comment
define('COMMENT_STATUS_STICK', 1);
define('COMMENT_STATUS_UNREAD', 2);
define('COMMENT_STATUS_READ', 3);
//Answer
define('EX_EXCEL', [
    'heading' => [
        'Mã chuyên mục',
        'Mã bài học',
        'Audio',
        'Nội dung câu hỏi',
        'Đáp án đúng',
        'A',
        'B',
        'C',
        'D'
    ],
    'data' => [
        '1',
        '1',
        '0',
        'Hello là gì ???',
        'A',
        'Xin chào',
        'Tạm biệt',
        'Tối nay',
        'Ngày mai'
    ],
    'heading_category' => [
        'Mã chuyên mục',
        'Tên chuyên mục',
    ],
    'heading_lesson' => [
        'Mã bài học',
        'Tên bài học',
        'Tên khóa học',
        'Mã khóa học'
    ]
]);

define('ANSWER_CORRECT', true);
define('ANSWER_FALSE', false);
//Lesson category verified
define('IS_PARENT', 0);
define('IS_TRIAL', 1);
define('IS_SHOW', 1);
define('VERIFIED', 1);
define('INACTIVE', 0);
define('ACTIVE', 1);
define('IS_SUPPER_ADMIN', 0);
define('IS_TESTER', 1);
