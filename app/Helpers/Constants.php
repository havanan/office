<?php

namespace App\Helpers;
class Constants
{
    const PER_PAGE_MAX = 9999;
    const NEWS_PUBLIC_STATUS = [
        0 => 'Ẩn',
        1 => 'Hiển thị'
    ];
    const CATEGORY_STATUS_ACTIVE = 1;

    const CURRENT_PAGE = 1;

    const CUSTOMER_STATUS = [
        0 => 'Đang khóa',
        1 => 'Đã kích hoạt'
    ];
    const CUSTOMER_ACTIVE = 1;

    const CATEGORY_STATUS = [
        0 => 'Đang khóa',
        1 => 'Đã kích hoạt'
    ];

    const CATEGORY_STATUS_LOCK = '';
//news
    const NEWS_UN_PUBLI = 0;
    const NEWS_PUBLIC = 1;

//Comment
    const COMMENT_STATUS_STICK = 1;
    const COMMENT_STATUS_UNREAD = 2;
    const COMMENT_STATUS_READ = 3;

//Lesson category verified
    const IS_PARENT = 0;
    const IS_TRIAL = 1;
    const IS_SHOW = 1;
    const VERIFIED = 1;
    const INACTIVE = 0;
    const ACTIVE = 1;
    const IS_SUPPER_ADMIN = 0;
    const IS_TESTER = 1;

}
