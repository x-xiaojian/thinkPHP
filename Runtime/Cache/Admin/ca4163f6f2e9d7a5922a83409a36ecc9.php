<?php if (!defined('THINK_PATH')) exit();?><div id="Config_Bar" class="Bar_tools">
  <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><a class='easyui-linkbutton' href='JavaScript:void(0);' data-options="iconCls:'iconfont icon-edit',plain:true" onclick="UpdateTabs('Config','<?php echo U('?id='.$key);?>','','iconfont icon-add');"><span><?php echo ($group); ?>配置</span></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<form id="Config_Submit_From" class="update_from" action="<?php echo U('group');?>&id=<?php echo ($id); ?>" data-options="tools:'#Config_Bar'">
  <table>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;?><tr>
      <th><?php echo ($config["title"]); ?> : <span><?php echo ($config["remark"]); ?></span></th>
    </tr>
    <tr>
      <td><?php switch($config["type"]): case "0": ?><input type="text" name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>" class="easyui-numberbox" style="height:30px;"><?php break;?>
          <?php case "1": ?><input type="text" name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>" class="easyui-textbox"><?php break;?>
          <?php case "2": ?><input name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>" type="text" class="easyui-textbox" data-options="required:false,multiline:true" style="width:300px; height:60px;"><?php break;?>
          <?php case "3": ?><input name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>" type="text" class="easyui-textbox" data-options="required:false,multiline:true" style="width:300px; height:60px;"><?php break;?>
          <?php case "4": ?><select name="config[<?php echo ($config["name"]); ?>]" class="easyui-combobox" data-options="value:'1',multiple:false,required:false,editable:false">
              <?php $_result=model_field_attr($config['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($config["value"]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select><?php break;?>
          <?php case "5": ?><input type="text" name="config[<?php echo ($config["name"]); ?>]" value="<?php echo ($config["value"]); ?>" class="easyui-kindeditor" config_date="1" style="width:600px; height:300px;"><?php break; endswitch;?></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr>
      <th style="text-align:center;"><a class="easyui-linkbutton" href="JavaScript:void(0);" onclick="From_Submit('Config')" data-options="iconCls:'iconfont icon-edit'"><span style="font-size:14px; font-weight:600;">保存</span></a></th>
    </tr>
  </table>
</form>