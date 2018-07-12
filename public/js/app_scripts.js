var info=[];
var bikes_qty=[];
var hr,date_in,date_out;
var helmet,lock,basket,babyseat,tax_st;
var subtotal=0,total=0,subtotal_with_discount=0,discount=0,insurance=0,tax=0;
$(document).ready(function(){
	$.get("http://192.168.0.100/json/biketype",{},function(data){
		data=JSON.parse(data);
		info=data;
		for(var id in data){
			bikes_qty[(parseInt(id)+1)]=0;
		}
	});
	$("#hrs").on("change",function () {
        if($("#hrs").val()>=0){
            hr=$("#hrs").val();
        } else if($("#hrs").val()<0){
            hr=0;
            $("#hrs").val(0);
        }
        if(hr == 0){
            $("#time_out").prop('disabled',false);
            $("#time_in").prop('disabled',false)
        } else if(hr>0) {
            $("#time_out").val('');
            $("#time_in").val('');
            $("#time_out").prop('disabled',true);
            $("#time_in").prop('disabled',true);
        }
    });
	$("#time_out").on("change",function () {
        date_out=$("#time_out").val();
        if($("#time_out").val().length==0 && $("#time_in").val().length==0){
            $("#hrs").prop('disabled',false);
            $("#time_out").prop('disabled',true);
            $("#time_in").prop('disabled',true);
        } else{
            $("#hrs").prop('disabled',true);
        }
    });
    $("#time_in").on("change",function () {
        date_in=$("#time_in").val();
        if($("#time_out").val().length==0 && $("#time_in").val().length==0){
            $("#hrs").prop('disabled',false);
            $("#time_out").prop('disabled',true);
            $("#time_in").prop('disabled',true);
        } else{
            $("#hrs").prop('disabled',true);
        }
    });
	$("#helmet").on("change",function () {
        if($("#helmet").val()>=0){
            helmet=$("#helmet").val();
        } else if($("#helmet").val()<0){
            helmet=0;
            $("#helmet").val(0);
        }
    });
    $("#lock").on("change",function () {
        if($("#lock").val()>=0){
            lock=$("#lock").val();
        } else if($("#lock").val()<0){
            lock=0;
            $("#lock").val(0);
        }
    });
    $("#basket").on("change",function () {
        if($("#basket").val()>=0){
            backet=$("#basket").val();
        } else if($("#basket").val()<0){
            backet=0;
            $("#basket").val(0);
        }
    });
    $("#babyseat").on("change",function () {
        if($("#babyseat").val()>=0){
            babyseat=$("#babyseat").val();
        } else if($("#babyseat").val()<0){
            babyseat=0;
            $("#babyseat").val(0);
        }
    });
	$("#dis").on("change",function () {
        if($("#dis").val()>=0){
            discount=$("#dis").val();
        } else if($("#dis").val()<0){
            discount=0;
            $("#dis").val(0);
        }
    });
    $("#ins").on("change",function () {
        if($("#ins").val()>=0){
            insurance=$("#ins").val();
        } else if($("#ins").val()<0){
            insurance=0;
            $("#ins").val(0);
        }
    });
    $("#taxx").on("click",function () {
        if($(this).is(":checked")){
            tax_st=1;
        } else {
            tax_st=0;
        }
    });
	$("#test").on("click",function(){
		total_price();
	});
});
function total_price(){
	subtotal=0;
	if(hr>0){
        alert("By hour");
		/*for(var i=0; i<=bikes_qty.length;i++){
			alert(info[i]['name'] + ' : ' + bikes_qty[i+1] + ' : ' + info[i]['price_h']);
			subtotal=subtotal+(parseFloat(info[i]['price_h'])*bikes_qty[i+1]*hr);
		}*/
    } else if(hr==0){
        if(date_out.length==10 && date_in.length==10){
            /*alert("By day");
			var date1=new Date(date_in);
            var date2=new Date(date_out);
            var day=(date1 - date2) / (1000*60*60*24);
			for(var i=0; i<=bikes_qty.length;i++){
				alert(info[i]['name'] + ' : ' + bikes_qty[i+1]);
				subtotal=subtotal+(parseFloat(info[i]['price_d'])*bikes_qty[i+1]*day);
			}*/
        } else if(date_out.length==0 && date_in.length==0){
            alert("By nothing");
			//subtotal=0;
        }        
    }
	/*alert("ddd");
	alert(subtotal);
    subtotal_with_discount=subtotal;
    if(subtotal>discount){
        subtotal_with_discount=subtotal-discount;
    }
	
	//alert(subtotal);
    if(tax_st==1){
        tax=parseFloat(((subtotal_with_discount/100)*8.875).toFixed(2));
    } else if(tax_st==0){ tax=0; }
    total=parseFloat(subtotal_with_discount)+parseFloat(insurance)+parseFloat(tax);
    $("#sb_t").val(subtotal);
    $("#sb_t_w_d").val(subtotal_with_discount);
    $("#tax").val(tax);
    $("#total").val(total);
	/*for(var i=0; i<=bikes_qty.length;i++){
		alert(info[i]['name'] + ' : ' + bikes_qty[i+1]);
		subtotal=subtotal+(parseFloat(info[i][''])
	}*/
}
function change_qty(id_bike){
	if($("#qty_"+parseInt(id_bike)).val()>=0){
		bikes_qty[id_bike]=$("#qty_"+id_bike).val();
	} else if($("#qty_"+id_bike).val()<0){
	    bikes_qty[id_bike]=0;
	    $("#qty_"+id_bike).val(0);
	}		   
}
