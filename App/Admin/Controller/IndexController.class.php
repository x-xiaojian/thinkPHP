<?php

/*
 * 默认首页控制器
 * Auth : Ghj
 * Time : 2015年4月11日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */

namespace Admin\Controller;

class IndexController extends AdminController {

    /**
     * 后台首页
     */
	public function index() {
		$this->assign ( "MainMenu",$this->GetMenu());
		$this->display ();
	}
	
    /**
     * 导航菜单
     */
    public function menu(){
		$pid=I('get.pid',0);
		$menus = $this->GetMenu();
		$this->ajaxReturn($menus[$pid]['children']);
    }
	
}
