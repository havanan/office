<?php

namespace App\Services\API;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Customer\CustomerRepository;

class AuthService {
  private $_customerRepo;

  public function __construct(CustomerRepository $customerRepo) {
      $this->_customerRepo = $customerRepo;
  }

  public function login($request) {
      $email = isset($request['email']) ? $request['email'] : null;

      $checkStatus = $this->_customerRepo->checkStatus($email);

      if ($checkStatus == false) {
          return \resFail('パスワードまたはメールアドレスが正しくありません。');
      }
    $credentials = $this->credentials($request);
    $token = $this->guard('api')->attempt($credentials);
    if ($token) { // ->setTTL(1)
      $user = $this->guard()->user();
      $this->_customerRepo->saveToken($token,$user->id);
      return $this->respondWithToken($token);
    }

    return \resFail(__('auth.msg_login_fail'));
  }
  public function register($request) {
    $params = $request->all();
    return $this->_customerRepo->create($params);
  }
  public function logout()
  {
    $this->guard()->logout();

    return resSuccess(__('auth.msg_logout_successs'));
  }

  public function refresh()
  {
    return $this->respondWithToken($this->guard()->refresh());
  }


  public function me()
  {
    return \resSuccessData([ 'user' => $this->guard()->user()]);
  }


  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
      return \resSuccessData([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => $this->guard()->factory()->getTTL() * 60,
          'user' => $this->guard()->user()
      ]);
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\Guard
   */
  public function guard()
  {
      return Auth::guard('api');
  }
    public function credentials($params)
    {
        $credentials = ['password'=>$params['password']];
        if (isset($params['email'])) {
            $credentials['email'] = $params['email'];
        }
        if (isset($params['social_id'])) {
            $credentials['social_id'] = $params['social_id'];
        }
        return $credentials;
    }
    public function lineLogin($credentials){

        $token = Auth::guard('api')->login($credentials);
        if ($token) { // ->setTTL(1)
            $user = $this->guard()->user();
            $this->_customerRepo->saveToken($token,$user->id);
            return $this->respondWithToken($token);
        }
        return \resFail(__('auth.msg_login_fail'));
    }
}
