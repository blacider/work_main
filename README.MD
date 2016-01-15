### 一些被污染的全局变量
+ exports、index

###一些多余的代码
在 views/xxx.php 的script中（在head.bs.html中已经写过了）
```javascript
<script type="text/javascript">
	var __BASEURL = "<?php echo $base_url; ?>";
</script>
```
