document.addEventListener("DOMContentLoaded", function(event) {
	var jq = jQuery;
	var ismultiple = jq('ul.ismultiple')
	if(ismultiple.length>0){
		if(typeof ismultiple!= "undefined"){
			ismultiple.each(function(ind,v){

				var vals = []
				jq(v).find('li').each(function(i,j){
					if(jq(j).text()!="value")
						vals.push(jq(j).text())
				})
				if(vals.length>0) {
					var select = Metro.getPlugin(document.getElementById(jq(v).attr('data-id')), 'select');
					select.val(vals);
				}
			})
		}
	}

});

function submit(){
	document.querySelector('form').submit()
}


