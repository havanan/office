<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

if(!function_exists('getUserCurrent')) {
  function getUserCurrent($guard = '') {
    if($guard) return Auth::guard($guard)->check() ? Auth::guard($guard)->user() : null;
    return Auth::check() ? Auth::user() : null;
  }
}


if(!function_exists('paginate')) {
  function paginate($items, $page = CURRENT_PAGE, $perPage = PER_PAGE, $additional_field = []) {
    if($page < 0) { $perPage = PER_PAGE_MAX; $page = CURRENT_PAGE;}
    $page = intval($page);
    $total = $items->count();
    $allPage = ceil($total / $perPage);
    if ($page > $allPage) { $page = $allPage; }
    $items = $items->skip(($page-1) * $perPage)->take($perPage)->get();
    $result = [
      'items' => $items,
      'currentPage' => $page,
      'pages' => $allPage,
      'total' => $total
    ];

    return Arr::collapse([$result, $additional_field]);
  }
}

if(!function_exists('getRedis')) {
  function getRedis($key) {
    return json_decode(MRedis::get($key));
  }
}
if(!function_exists('setRedis')) {
  function setRedis($key, $value) {
    MRedis::set($key, json_encode($value));
  }
}

if(!function_exists('setKeyRedis')) {
  function setKeyRedis($request) {
    $key = '';
    foreach($request->all() as $k => $v) {
      $key .= '_' . $k .'_' . $v;
    }
    return base64_encode($key);

  }
}
if(!function_exists('delKeysRedis')) {
  function delKeysRedis($key) {
    $keys = MRedis::keys("*$key*");
    MRedis::del($keys);

  }
}

if(!function_exists('getMilliseconds')) {
  function getMilliseconds($date = null) {
    if($date) return time() * 1000;
    return Carbon\Carbon::parse($date)->timestamp;
  }
}
if(!function_exists('formatCurrency')) {
  function formatCurrency($currency = 0) {
    return '¥' . number_format($currency, 2);
  }
}
if(!function_exists('formatDate')) {
  function formatDate($date = null, $format = 'd F Y') {
    if($date) return Carbon\Carbon::parse($date)->format($format);
    return '-';
  }
}

function _toSlugTransliterate($str) {
  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
  $str = preg_replace("/(đ)/", 'd', $str);

  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
  $str = preg_replace("/(Đ)/", 'D', $str);
  return $str;
}
function toSlug($string, $isRandom = false, $separator = '-') {
  $string = _toSlugTransliterate($string);

  $regex = '/[^一-龠ぁ-ゔァ-ヴーａ-ｚＡ-Ｚ０-９a-zA-Z0-9々〆〤.+ -]|^\s+|\s+$/u';
  $string = preg_replace($regex, '', $string);

  $string = mb_strtolower($string);

  $string = preg_replace("/[ {$separator}]+/", $separator, $string);
  return $string . ($isRandom ? ('-' . Str::random(6)) : '');
}
