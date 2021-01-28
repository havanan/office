<?php
namespace App\Helpers;

class Responses
{
    public static function writeResponse($code, $msg)
    {
        return response()->json([
            'code' => $code,
            'message' => $msg
        ]);
    }

    public static function writeResponseData($code, $msg, $data)
    {
        return response()->json([
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ]);
    }

    public static function writeResponseError($code, $msg, $error)
    {
        return response()->json([
            'code' => $code,
            'message' => $msg,
            'errors' => $error
        ]);
    }

    public static function resSuccess($msg = null)
    {
        $msg = $msg ? $msg : __('systems.msgSuccess');
        return self::writeResponse(200, $msg);
    }

    public static function resSuccessData($data, $msg = null)
    {
        $msg = $msg ? $msg : __('systems.msgSuccess');
        return self::writeResponseData(200, $msg, $data);
    }

    public static function resFail($msg = null, $code = 500)
    {
        $msg = $msg ? $msg : __('systems.msgFail');
        return self::writeResponse($code, $msg);
    }

    public static function resIIS($msg = null)
    {
        $msg = $msg ? $msg : __('systems.msg_iis');
        return self::writeResponse(500, $msg);
    }
}
