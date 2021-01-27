<?php

//return response no data
if(!function_exists('writeResponse')) {
    function writeResponse($code, $msg) {
        return response()->json([
            'code' => $code,
            'message' => $msg
        ]);
    }
}

//return response data
if(!function_exists('writeResponseData')) {
    function writeResponseData($code, $msg, $data) {
        return response()->json([
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ]);
    }
}

//return response error
if(!function_exists('writeResponseError')) {
    function writeResponseError($code, $msg, $error) {
        return response()->json([
            'code' => $code,
            'message' => $msg,
            'errors' => $error
        ]);
    }
}

//return response success
if(!function_exists('resSuccess')) {
    function resSuccess($msg = null) {
        $msg = $msg ?? __('systems.msgSuccess');
        return writeResponse(200, $msg);
    }
}

//return response success data
if(!function_exists('resSuccessData')) {
    function resSuccessData($data, $msg = null) {
        $msg = $msg ?? __('systems.msgSuccess');
        return writeResponseData(200, $msg, $data);
    }
}

//return response fail status
if(!function_exists('resFail')) {
    function resFail($msg = null, $code = 500) {
        $msg = $msg ?? __('systems.msgFail');
        return writeResponse($code , $msg);
    }
}


//return response system fail
if(!function_exists('resIIS')) {
    function resIIS($msg = null) {
        $msg = $msg ?? __('systems.msg_iis');
        return writeResponse(500, $msg);
    }
}
