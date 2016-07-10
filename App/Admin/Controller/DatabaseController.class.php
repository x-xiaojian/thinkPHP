<?php

/*
 * 配置管理控制器
 * Auth : Ghj
 * Time : 2015-06-09
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

use Think\Db;
use GMS\Database;

class DatabaseController extends AdminController {
	
	/**
	 * 数据库备份/还原列表
	 */
	public function import_list($type = null) {
		if (IS_POST) {
			$path = C ( 'DATA_BACKUP_PATH' );
			if (! is_dir ( $path )) {
				mkdir ( $path, 0755, true );
			}
			$path = realpath ( $path );
			$flag = \FilesystemIterator::KEY_AS_FILENAME;
			$glob = new \FilesystemIterator ( $path, $flag );
			
			$list = array ();
			foreach ( $glob as $name => $file ) {
				if (preg_match ( '/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name )) {
					$name = sscanf ( $name, '%4s%2s%2s-%2s%2s%2s-%d' );
					
					$date = "{$name[0]}-{$name[1]}-{$name[2]}";
					$time = "{$name[3]}:{$name[4]}:{$name[5]}";
					$part = $name [6];
					
					if (isset ( $list ["{$date} {$time}"] )) {
						$info = $list ["{$date} {$time}"];
						$info ['part'] = max ( $info ['part'], $part );
						$info ['size'] = $info ['size'] + $file->getSize ();
					} else {
						$info ['part'] = $part;
						$info ['size'] = $file->getSize ();
					}
					$extension = strtoupper ( pathinfo ( $file->getFilename (), PATHINFO_EXTENSION ) );
					$info ['compress'] = ($extension === 'SQL') ? '-' : $extension;
					$info ['time'] = strtotime ( "{$date} {$time}" );
					
					$list ["{$date} {$time}"] = $info;
				}
			}
			foreach ( $list as $list_key => $list_one ) {
				$_list_one ['id'] = date ( 'Ymd-His', $list_one ['time'] );
				$_list_one ['part'] = $list_one ['part'];
				$_list_one ['size'] = format_bytes ( $list_one ['size'] );
				$_list_one ['compress'] = $list_one ['compress'];
				$_list_one ['time'] = $list_key;
				$_list_one ['operate'] = '
					<a href="#" onclick="Ajax_DatabaseImport(\'' . U ( 'import', array (
						'time' => $list_one ['time'] 
				) ) . '\',\'DatabaseImport_Data_List\');">还原</a>
					<a href="#" onclick="Datagrid_Ajax(\'' . U ( 'del', array (
						'time' => $list_one ['time'] 
				) ) . '\',\'DatabaseImport_Data_List\');">删除</a>
				';
				$_list [] = $_list_one;
			}
			$total = count ( $_list );
			if ($total == 0) {
				$_list = '';
			}
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$operate = '
			<a class="easyui-linkbutton" href="JavaScript:void(0);" data-options="iconCls:\'iconfont icon-refresh\',plain:true" onclick="Data_Reload(\'DatabaseImport_Data_List\');">刷新还原列表</a>
			';
			$this->assign ( 'operate', $operate );
			$this->display ();
		}
	}
	/**
	 * 数据库备份/还原列表
	 */
	public function export_list($type = null) {
		if (IS_POST) {
			$Db = Db::getInstance ();
			$list = $Db->query ( 'SHOW TABLE STATUS' );
			$_list = array_map ( 'array_change_key_case', $list );
			foreach ( $_list as $list_key => $list_one ) {
				$_list [$list_key] ['operate'] = '
					<a href="#" onclick="Datagrid_Ajax(\'' . U ( 'optimize', array (
						'tables' => $_list [$list_key] ['name'] 
				) ) . '\',\'DatabaseExport_Data_List\');">优化表</a>
					<a href="#" onclick="Datagrid_Ajax(\'' . U ( 'repair', array (
						'tables' => $_list [$list_key] ['name'] 
				) ) . '\',\'DatabaseExport_Data_List\');">修复表</a>
				';
				$_list [$list_key] ['id'] = $_list [$list_key] ['name'];
			}
			$total = count ( $_list );
			if ($total == 0) {
				$_list = '';
			}
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$operate = '
			<a class="easyui-linkbutton" href="JavaScript:void(0);" data-options="iconCls:\'iconfont icon-refresh\',plain:true" onclick="Data_Reload(\'DatabaseExport_Data_List\');">刷新备份列表</a>
			<a class="easyui-linkbutton" href="JavaScript:void(0);" data-options="iconCls:\'iconfont icon-viewgallery\',plain:true" onclick="Ajax_DatabaseExport(\'DatabaseExport_Data_List\');">备份</a>
			<a class="easyui-linkbutton" href="JavaScript:void(0);" data-options="iconCls:\'iconfont icon-rfq\',plain:true" onclick="Datagrid_Ajax_Checkbox(\'' . U ( 'optimize' ) . '\',\'DatabaseExport_Data_List\');">优化表</a>
			<a class="easyui-linkbutton" href="JavaScript:void(0);" data-options="iconCls:\'iconfont icon-survey\',plain:true" onclick="Datagrid_Ajax_Checkbox(\'' . U ( 'repair' ) . '\',\'DatabaseExport_Data_List\');">修复表</a>
			';
			$this->assign ( 'operate', $operate );
			$this->display ();
		}
	}
	
	/**
	 * 优化表
	 * 
	 * @param String $tables
	 *        	表名
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function optimize() {
		$tables = I ( 'post.ids' );
		$table = I ( 'get.tables' );
		if ($tables != '') {
			$tables = str_replace ( ",", "`,`", $tables );
			$Db = Db::getInstance ();
			$list = $Db->query ( "OPTIMIZE TABLE `{$tables}`" );
			if ($list) {
				$this->success ( "数据表优化完成！" );
			} else {
				$this->error ( "数据表优化出错请重试！" );
			}
		} elseif ($table != '') {
			$Db = Db::getInstance ();
			$list = $Db->query ( "OPTIMIZE TABLE `{$table}`" );
			if ($list) {
				$this->success ( "数据表'{$table}'优化完成！" );
			} else {
				$this->error ( "数据表'{$table}'优化出错请重试！" );
			}
		} else {
			$this->error ( "请指定要优化的表！" );
		}
	}
	
	/**
	 * 修复表
	 * 
	 * @param String $tables
	 *        	表名
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function repair() {
		$tables = I ( 'post.ids' );
		$table = I ( 'get.tables' );
		if ($tables != '') {
			$tables = str_replace ( ",", "`,`", $tables );
			$Db = Db::getInstance ();
			$list = $Db->query ( "REPAIR TABLE `{$tables}`" );
			if ($list) {
				$this->success ( "数据表修复完成！" );
			} else {
				$this->error ( "数据表修复出错请重试！" );
			}
		} elseif ($table != '') {
			$Db = Db::getInstance ();
			$list = $Db->query ( "REPAIR TABLE `{$table}`" );
			if ($list) {
				$this->success ( "数据表'{$table}'修复完成！" );
			} else {
				$this->error ( "数据表'{$table}'修复出错请重试！" );
			}
		} else {
			$this->error ( "请指定要修复的表！" );
		}
	}
	
	/**
	 * 删除备份文件
	 * 
	 * @param Integer $time
	 *        	备份时间
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function del($time = 0) {
		if ($time) {
			$name = date ( 'Ymd-His', $time ) . '-*.sql*';
			$path = realpath ( C ( 'DATA_BACKUP_PATH' ) ) . DIRECTORY_SEPARATOR . $name;
			array_map ( "unlink", glob ( $path ) );
			if (count ( glob ( $path ) )) {
				$this->error ( '备份文件删除失败，请检查权限！' );
			} else {
				$this->success ( '备份文件删除成功！' );
			}
		} else {
			$this->error ( '参数错误！' );
		}
	}
	
	/**
	 * 备份数据库
	 * 
	 * @param String $tables
	 *        	表名
	 * @param Integer $id
	 *        	表ID
	 * @param Integer $start
	 *        	起始行数
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function export() {
		$ids = I ( 'post.ids' );
		$id = I ( 'post.id' );
		if (IS_POST && ! empty ( $ids )) {
			$path = C ( 'DATA_BACKUP_PATH' );
			if (! is_dir ( $path )) {
				mkdir ( $path, 0755, true );
			}
			// 读取备份配置
			$config = array (
					'path' => realpath ( $path ) . DIRECTORY_SEPARATOR,
					'part' => C ( 'DATA_BACKUP_PART_SIZE' ),
					'compress' => C ( 'DATA_BACKUP_COMPRESS' ),
					'level' => C ( 'DATA_BACKUP_COMPRESS_LEVEL' ) 
			);
			
			// 检查是否有正在执行的任务
			$lock = "{$config['path']}backup.lock";
			if (is_file ( $lock )) {
				$this->error ( '检测到有一个备份任务正在执行，请稍后再试！' );
			} else {
				// 创建锁文件
				file_put_contents ( $lock, NOW_TIME );
			}
			
			// 检查备份目录是否可写
			is_writeable ( $config ['path'] ) || $this->error ( '备份目录不存在或不可写，请检查后重试！' );
			session ( 'backup_config', $config );
			
			// 生成备份文件信息
			$file = array (
					'name' => date ( 'Ymd-His', NOW_TIME ),
					'part' => 1 
			);
			
			session ( 'backup_file', $file );
			
			// 缓存要备份的表
			session ( 'backup_tables', $ids );
			
			// 创建备份文件
			$Database = new Database ( $file, $config );
			if (false !== $Database->create ()) {
				$tab = array (
						'id' => 0,
						'start' => 0 
				);
				$this->success ( '初始化成功！', '', array (
						'id' => 0 
				) );
			} else {
				$this->error ( '初始化失败，备份文件创建失败！' );
			}
		} elseif (IS_POST && $id != '') {
			$backup_tables = session ( 'backup_tables' );
			$tables = explode ( ",", $backup_tables );
			
			$start = I ( 'post.start' );
			$Database = new Database ( session ( 'backup_file' ), session ( 'backup_config' ) );
			$start = $Database->backup ( $tables [$id], $start );
			if (false === $start) { // 出错
				$this->error ( $tables [$id] . '备份出错,终止执行！', '', array (
						'id' => "over" 
				) );
			} elseif (0 === $start) { // 下一表
				if (isset ( $tables [++ $id] )) {
					$this->success ( $tables [$id] . '备份完成,正在备份' . $tables [++ $id], '', array (
							'id' => $id,
							'start' => 0 
					) );
				} else { // 备份完成，清空缓存
					unlink ( session ( 'backup_config.path' ) . 'backup.lock' );
					session ( 'backup_tables', null );
					session ( 'backup_file', null );
					session ( 'backup_config', null );
					$this->success ( '全部备份完成！', '', array (
							'id' => "over" 
					) );
				}
			} else {
				$rate = floor ( 100 * ($start [0] / $start [1]) );
				$this->success ( "正在备份...({$rate}%)", '', array (
						'id' => $id,
						'start' => $start [0] 
				) );
			}
		} else { // 出错
			$this->error ( '参数错误！', '', array (
					'id' => "over" 
			) );
		}
	}
	
	/**
	 * 还原数据库
	 * 
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	public function import($time = 0, $part = null, $start = null) {
		if (is_numeric ( $time ) && is_null ( $part ) && is_null ( $start )) { // 初始化
		                                                            // 获取备份文件信息
			$name = date ( 'Ymd-His', $time ) . '-*.sql*';
			$path = realpath ( C ( 'DATA_BACKUP_PATH' ) ) . DIRECTORY_SEPARATOR . $name;
			$files = glob ( $path );
			$list = array ();
			foreach ( $files as $name ) {
				$basename = basename ( $name );
				$match = sscanf ( $basename, '%4s%2s%2s-%2s%2s%2s-%d' );
				$gz = preg_match ( '/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename );
				$list [$match [6]] = array (
						$match [6],
						$name,
						$gz 
				);
			}
			ksort ( $list );
			
			// 检测文件正确性
			$last = end ( $list );
			if (count ( $list ) === $last [0]) {
				session ( 'backup_list', $list ); // 缓存备份列表
				$this->success ( '初始化完成！', '', array (
						'part' => 1,
						'start' => 0 
				) );
			} else {
				$this->error ( '备份文件可能已经损坏，请检查！' );
			}
		} elseif (is_numeric ( $part ) && is_numeric ( $start )) {
			$list = session ( 'backup_list' );
			$db = new Database ( $list [$part], array (
					'path' => realpath ( C ( 'DATA_BACKUP_PATH' ) ) . DIRECTORY_SEPARATOR,
					'compress' => $list [$part] [2] 
			) );
			
			$start = $db->import ( $start );
			
			if (false === $start) {
				$this->error ( '还原数据出错！' );
			} elseif (0 === $start) { // 下一卷
				if (isset ( $list [++ $part] )) {
					$data = array (
							'part' => $part,
							'start' => 0 
					);
					$this->success ( "正在还原...#{$part}", '', $data );
				} else {
					session ( 'backup_list', null );
					$this->success ( '还原完成！' );
				}
			} else {
				$data = array (
						'part' => $part,
						'start' => $start [0] 
				);
				if ($start [1]) {
					$rate = floor ( 100 * ($start [0] / $start [1]) );
					$this->success ( "正在还原...#{$part} ({$rate}%)", '', $data );
				} else {
					$data ['gz'] = 1;
					$this->success ( "正在还原...#{$part}", '', $data );
				}
			}
		} else {
			$this->error ( '参数错误！' );
		}
	}
}
