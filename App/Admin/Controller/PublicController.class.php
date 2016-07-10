<?php

/*
 * 后台公共控制器
 * Auth : Ghj
 * Time : 2015年4月11日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

use Common\Controller\CoreController;

class PublicController extends CoreController {
	
	/**
	 * 后台用户登录
	 */
	public function login($username = null, $password = null, $verify = null) {
		if (session ( C ( 'AUTH_KEY' ) )) { // 还没登录 跳转到登录页面
			$this->redirect ( C ( 'AUTH_USER_INDEX' ) );
		}
		if (IS_POST) {
			$username = I ( "post.username", "", "trim" );
			$password = I ( "post.password", "", "trim" );
			if (empty ( $username ) || empty ( $password )) {
				$this->error ( "用户名或者密码不能为空，请重新输入！", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
			}
			$map = array (
					'username' => $username,
					'password' => $password,
					'status' => 1 
			);
			$userinfo = M ( 'User' )->where ( $map )->find ();
			if ($userinfo) {
				session ( C ( 'AUTH_KEY' ), $userinfo ['id'] );
				session ( 'userinfo', $userinfo );
				R ( 'Admin/AdminController/GetMenu' );
				$this->success ( "登录成功！", U ( C ( 'AUTH_USER_INDEX' ) ) );
			} else {
				$this->error ( "用户名密码错误或者此用户已被禁用！", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
			}
		} else {
			$this->display ();
		}
	}
	
	/* 退出登录 */
	public function logout() {
		if (is_login ()) {
			D ( 'Member' )->logout ();
			session ( '[destroy]' );
			$this->success ( '退出成功！', U ( 'login' ) );
		} else {
			$this->redirect ( 'login' );
		}
	}
	public function verify() {
		$verify = new \Think\Verify ();
		$verify->entry ( 1 );
	}
/*Todo:通过调用方法规避验证，需处理*/
	public function api(){
		$url=I('get.url');
		$var=I('get.var');
		$arr=array($var);
		R($url,$arr);
	}
}
