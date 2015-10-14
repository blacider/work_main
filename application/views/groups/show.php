


	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<!-- #section:plugins/fuelux.treeview -->
		

			<div class="col-sm-6">
				<div class="widget-box widget-color-green2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">部门结构</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<div id="tree2" class="tree"></div>
						</div>
					</div>
				</div>
			</div>
		

		<!-- /section:plugins/fuelux.treeview -->
		<script type="text/javascript">
			var $assets = "../../assets";//this will be used in fuelux.tree-sampledata.js
		</script>

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->

<!-- page specific plugin scripts -->

<script language="javascript">
var __BASE = "<?php echo $base_url; ?>";
</script>
<script type="text/javascript">

		Array.prototype.remove=function(obj){ 
			for(var i =0;i <this.length;i++){ 
				var temp = this[i]; 
				if(!isNaN(obj)){ 
				temp=i; 
			} 
			if(temp == obj){ 
				for(var j = i;j <this.length;j++){ 
				this[j]=this[j+1]; 
			} 
				this.length = this.length-1; 
				} 
			} 
			} 
	var scripts = [null,"/static/ace/js/fuelux/fuelux.tree.min.js", null]
	ace.load_ajax_scripts(scripts, function() {
	  //inline scripts related to this page
		 jQuery(function($){
		 $.ajax({
		 	url:__BASE+ "/members/getgroups",
		 	method:'GET',
		 	dataType:'json',
		 	success:function(data){

		 			var ace_icon = ace.vars['icon'];
					//class="'+ace_icon+' fa fa-file-text grey"
					//becomes
					//class="ace-icon fa fa-file-text grey"
					var js_data = {};
					var obj = new Array();
					var unroot = new Array();
					for(var i = 0 ; i < data.length ; i++)
					{
						if(data[i]['pid'] == "0")
						{
							js_data[data[i]['name']] = {name: data[i]['name'], id:data[i]['id'] ,type: 'folder', 'icon-class':'red'};	
							var item = js_data[data[i]['name']];
							item['additionalParameters']={'children':{'members': {name: '成员', type: 'folder', 'icon-class':'pink'}}};
							item['additionalParameters']['children']['members']['additionalParameters']={};
							var param = item['additionalParameters']['children']['members']['additionalParameters'];
							param['children'] = [];
							var mem = param['children'];
							for(var j = 0; j< data[i]['members'].length; j++)
							{
								var temp = {name: '<i class="'+ace_icon+' fa fa-users blue"></i>'+data[i]['members'][j]['nickname'],type:'item'};
								mem.push(temp);
							}

							obj.push({id:data[i]['id'],'item':js_data[data[i]['name']]});

						}
						else if(data[i]['pid'] > 0)
						{
							unroot.push(data[i]);
						}
					}
					//寻找子部门
					while(unroot.length!=0)
					{
						var tempobj = new Array();
						for(var num = 0; num < obj.length;num++)
						{
							for(var unum = 0 ; unum < unroot.length ; unum++)
							{
								if(unroot[unum]['pid'] == obj[num]['id'])
								{
										//item['additionalParameters']={'children':{'members': {name: '成员', type: 'folder', 'icon-class':'pink'}}};
										//item['additionalParameters']['children']['members']['additionalParameters']={};
										//var param = item['additionalParameters']['children']['members']['additionalParameters'];
										//param['children'] = [];
										//var mem = param['children'];

									
									  obj[num]['item']['additionalParameters']['children'][unroot[unum]['name']]={name:unroot[unum]['name'],id:unroot[unum]['id'], type: 'folder', 'icon-class':'pink'};
									  //obj[num]['item']['additionalParameters']={'children':{unroot[unum]['name']:{name:unroot[unum]['name'], type: 'folder', 'icon-class':'pink'}}}
									  var tempitem = obj[num]['item']['additionalParameters']['children'][unroot[unum]['name']];
									 // tempitem={name:unroot[unum]['name'], type: 'folder', 'icon-class':'pink'};
									  tempitem['additionalParameters'] = {'children':{'members': {name: '成员', type: 'folder', 'icon-class':'pink'}}};
									  tempitem['additionalParameters']['children']['members']['additionalParameters']={};
									  var param = tempitem['additionalParameters']['children']['members']['additionalParameters'];
									  param['children'] = [];
									  var mem = param['children'];

									  /*var param = tempitem['additionalParameters'];
									  param['children'] = {};
									  var tempitem2 = param['children'];
									  tempitem2['members'] =  {name: '成员', type: 'folder', 'icon-class':'pink'};
									  //tempitem2[unroot[unum]['name']] =  {name: 'Wallpapers', type: 'folder', 'icon-class':'pink'};
									  var mem = param['children'];*/
									  for(var j = 0; j< unroot[unum]['members'].length; j++)
										{
											var temp = {name: '<i class="'+ace_icon+' fa fa-users blue"></i>'+unroot[unum]['members'][j]['nickname'],type:'item'};
											mem.push(temp);
										}
										tempobj.push({id:unroot[unum]['id'],'item':tempitem});
									  unroot.remove(unum);
								}
							}
						}

						obj = tempobj;
					} 
					
					var treeDataSource = new DataSourceTree({data: js_data});

					$('#tree2').ace_tree({
						dataSource: treeDataSource ,
						loadingHTML:'<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>',
						'open-icon' : 'ace-icon fa fa-cog',
						'close-icon' : 'ace-icon fa fa-cogs',
						'selectable' : true,
						'selected-icon' : null,
						'unselected-icon' : null
					});
					
					
					$('#tree2')
					.on('updated', function(e, result) {
						//result.info  >> an array containing selected items
						//result.item
						//result.eventType >> (selected or unselected)
					})
					.on('selected', function(e) {
					})
					.on('unselected', function(e) {
					})
					.on('opened', function(e,result) {
						//var _gid = _data;
					})
					.on('closed', function(e) {
					});

			},
			error:function(){
			}

	});

		/**
		$('#tree1').on('loaded', function (evt, data) {
		});

		$('#tree1').on('opened', function (evt, data) {
		});

		$('#tree1').on('closed', function (evt, data) {
		});

		$('#tree1').on('selected', function (evt, data) {
		});
		*/
});
	});
</script>
<script type="text/javascript">
	
	var DataSourceTree = function(options) {
	this._data 	= options.data;
	this._delay = options.delay;
}

DataSourceTree.prototype.data = function(options, callback) {
	var self = this;
	var $data = null;

	if(!("name" in options) && !("type" in options)){
		$data = this._data;//the root tree
		callback({ data: $data });
		return;
	}
	else if("type" in options && options.type == "folder") {
		if("additionalParameters" in options && "children" in options.additionalParameters)
			$data = options.additionalParameters.children;
		else $data = {}//no data
	}
	
	if($data != null)//this setTimeout is only for mimicking some random delay
		setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);

	//we have used static data here
	//but you can retrieve your data dynamically from a server using ajax call
	//checkout examples/treeview.html and examples/treeview.js for more info
};

</script>
