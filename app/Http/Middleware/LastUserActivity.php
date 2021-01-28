<?php

namespace App\Http\Middleware;

use App\Models\LogAccess;
use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class LastUserActivity {

    public function handle($request, Closure $next){
		if(isset(Auth::guard('admin')->user()->id)){
            $admin_id = Auth::guard('admin')->user()->id;
			$user = User::find($admin_id);
            $url = urldecode($request->url());
            $log = LogAccess::where('url','=', $url)->where('admin_id','=', $admin_id)->whereDate('created_at', '=', date('Y-m-d'))->first();
            if(is_null($log)){
                $log = new LogAccess();
                $log->admin_id = $admin_id;
                $log->url = $url;
            }
            $log->near_time = Carbon::now();
            $log->ip = $request->ip();
            $log->user_agent= $request->server('HTTP_USER_AGENT');
            $log->save();
        }
    	return $next($request);
    }

}
