##前端篇
### 一些被污染的全局变量
+ exports、index

###一些多余的代码
在 views/xxx.php 的script中（在head.bs.html中已经写过了）
```javascript
<script type="text/javascript">
	var __BASEURL = "<?php echo $base_url; ?>";
</script>
```


##界面规范篇（UI）
###异步等待需要的loading
+ 加载内容的loading
+ 删除，更新，添加对象的loading，因为这三类操作都需要与服务器通讯，操作过程会有一个等待时间

###对话框，弹层
+ 对话框的基本构造，按钮，莫态等
+ 系统提示框：警告：错误：正确：
+ 气泡指引
详细可参见(http://semantic-ui.com/modules/shape.html)



