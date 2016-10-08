$("body").on('click','.pagegoto',function(){
	var page = $(".page-num").val();
	if(page == undefined){
		alert('请输入正确的跳转页数');
	}else{
		var lastpage = $(this).attr('max');
		if(parseInt(page)>parseInt(lastpage)){
			page = lastpage;
		}
		var ref = $(this).attr('ref');
		ref = ref.replace('page=0','page='+page);
		window.location.href = ref;
	}
});