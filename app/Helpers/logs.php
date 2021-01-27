<?php
if(!function_exists('writeLog')) {
  function writeLog($msg = '', $level = 0) {
    $action = getAction();
    $str = formatLog($action, $msg);
    switch($level) {
      case 1:
        Log::warning($str);
        break;
      case 2:
        Log::info($str);
        break;
      default:
        Log::error($str);
        break;
    }
  }
}

if(!function_exists('getAction')) {
  function getAction() {
    $route = request()->route();
    if($route) {
      $action = $route->getAction();
      if(!isset($action['controller'])) return __('system.msg_no_controller');
      $controller = explode('\\',request()->route()->getAction()['controller']);
      return Arr::last($controller);
    }
    return '';
  }
}

function formatLog($action, $msg) {
  return request()->fullUrl() . ' - ' . ($msg ? $action .  ' - ' . $msg : $action);
}
