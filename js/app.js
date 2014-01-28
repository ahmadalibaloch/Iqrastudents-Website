$(function(){
	bind_all($(document.body), location.href);
});


function bind_all($ref_cont, source_url){
	console.log('bind '+$ref_cont[0].nodeName+' to '+source_url);
	
	//bind confirm first as it will set stop attr for action function
	$('a[confirm]', $ref_cont).each(function(){
		var $el = $(this);
		$el.click(function(){
			var r = confirm($el.attr('confirm'));
			if(r == false)	$el.attr('stop', 'yes');
			else $el.attr('stop', 'no');
			return r;
		});
	});
	
	$('[ajax]', $ref_cont).each(function(){
		var $el = $(this),
		node_name = $el[0].nodeName,
		options = {},
		ajax = $el.attr('ajax');

		if(ajax){
			ajax = ajax.replace(/=/g,'":"');
			ajax = ajax.replace(/\|/g,'","');
			ajax = '{"' + ajax + '"}';
			options = JSON.parse(ajax);
		}

		options.url = options.url || $el.attr('action') || $el.attr('href') || source_url;
		options.container = options.container ? $('#'+options.container) : $el;

		if(node_name == 'FORM') options.container = $el.parent();

		options.success = function(result){
			if(result){
				if(result.match && result.match(/location\.reload/)) window.location.reload();
				else if(result.match && result.match(/^http/)) window.location = result;
				else{
					if(options.callback){
						var cb = options.callback + '(result)';
						result = eval(cb);
					}
					
					if(result){
						options.container.html(result);
						bind_all(options.container, options.url);
						if(node_name == 'A') options.container.dialog({title:$el.attr('title'),width:'auto'});
					}
				}
				
				$el.attr('stop', 'no');
			}
		};

		action = function(){
			console.log('action for '+$el[0].nodeName);
			var stop = $el.attr('stop');
			if(stop && stop == 'yes') return false;
			if(node_name == 'FORM'){
				if($el.attr('enctype')){
					var form_id = $el.attr('id'), idoc;
					$el.attr('action', options.url);
					$el.attr('target', 'ajaxiframe');
					$el.append('<input type=hidden name=HTTP_X_REQUESTED_WITH value=IFrame>');
					$('#ajaxiframe').load(function(){
						idoc = this.contentDocument ? this.contentDocument : this.contentWindow.document;
						options.success(idoc.body.innerHTML);
					});
					$el.attr('stop', 'yes');
					return true;
				}
				else{
					options.data = $el.serialize();
					options.type = $el.attr('method');
				}
			}
			$.ajax(options);
			$el.attr('stop', 'yes');
			return false;
		};

		switch(node_name){
			case 'FORM':
				$el.submit(action);
				break;
			case 'A':
				$el.click(action);
				break;
			default:
				action();
		}
	});

	$('input[autocomp]', $ref_cont).each(function(){
		var $el = $(this), autocomp = $el.attr('autocomp'), ajax_url = $el.attr('url') || source_url, qa = ajax_url.match(/\?/) ? '&' : '/?', $setid = $('#'+$el.attr('setid')), cache = {};
		$el.autocomplete({
			minLength : 1,
			source : function(request, response){
				if(request.term in cache){
					response(cache[request.term]); return;
				}
				$.ajax({
					url : ajax_url + qa + 'autocomp=' + autocomp + '&term=' + request.term,
					dataType : 'json',
					success : function(data){
						cache[request.term] = data;
						response(data);
					}
				});
			},
			select : function(event, ui){
				if($setid) $setid.val(ui.item.id);
			}
		});
	});

	$('input[date]', $ref_cont).each(function(){
		var $el = $(this);
		$el.datepicker({dateFormat:'yy-mm-dd'});
	});
}