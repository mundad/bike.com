var info=[];
var bikes_qty=[];
var prices_h=[];
var prices_d=[];
var insurance_b=[];
var hr=0,date_in,date_out;
var helmet,lock,basket,babyseat,tax_st=1,ins_st=0;
var subtotal=0,total=0,subtotal_with_discount=0,discount=0,insurance=0,tax=0;
$(document).ready(function(){
	$.get("http://192.168.0.100/json/biketype",{},function(data){
		data=JSON.parse(data);
		info=data;
		for(var id in data){
			bikes_qty[(parseInt(id)+1)]=0;
			prices_h[(parseInt(id)+1)]=data[id]['price_h'];
			prices_d[(parseInt(id)+1)]=data[id]['price_d'];
			insurance_b[(parseInt(id)+1)]=data[id]['insurance'];
		}
	});
	$("#phone").on("input",function(){
		if($("#phone").val().length>5){
			var n=$("#phone").val();
			alert("sss");
			$.post( "http://192.168.0.100/json/user", { phone: n }, function( data ) {
			  alert(data);
			}, "json");
            /*$.post('http://192.168.0.100/json/user',{ phone: n },function (data) {
                data=JSON.parse(data);
				alert("sss");
                /*for(var id in data){
                    info[id]=data[id];
                }
                $("#name").val(info['name']);
                $("#secondname").val(info['second_name']);
                $("#adress").val(info['adress']);
                $("#email").val(info['email']);
            });*/
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
		total_price();
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
		total_price();
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
		total_price();
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
		total_price();
    });
    $("#taxx").on("click",function () {
        if($(this).is(":checked")){
            tax_st=1;
        } else {
            tax_st=0;
        }
		total_price();
    });
	$("#insur").on("click",function () {
        if($(this).is(":checked")){
            ins_st=1;
        } else {
            ins_st=0;
        }
		total_price();
    });
	$("#test").on("click",function(){
		total_price();
	});
});
function total_price(){
	subtotal=0;
	total=0;
	insurance=0;
	if(hr>0){
		for(var i=1; i<=bikes_qty.length-1;i++){
			subtotal=subtotal+(parseFloat(prices_h[i])*parseInt(bikes_qty[i])*hr);
			if(bikes_qty[i]>0){
				insurance=insurance+insurance_b[i];
			}
		}
    } else if(hr==0 && date_out.length==10 && date_in.length==10 ){
			var date1=new Date(date_in);
            var date2=new Date(date_out);
            var day=(date1 - date2) / (1000*60*60*24);
			for(var i=1; i<=bikes_qty.length-1;i++){
				subtotal=subtotal+(parseFloat(prices_d[i])*parseInt(bikes_qty[i])*day);
				if(bikes_qty[i]>0){
					insurance=insurance+insurance_b[i];
				}
			}      
    }
	subtotal_with_discount=subtotal;
    if(subtotal>discount){
        subtotal_with_discount=subtotal-discount;
    }
    if(tax_st==1){
        tax=parseFloat(((subtotal_with_discount/100)*8.875).toFixed(2));
    } else if(tax_st==0){ tax=0; }
	if(ins_st==1){
        total=parseFloat(subtotal_with_discount)+parseFloat(insurance)+parseFloat(tax);
			$("#ins").val(insurance);
    } else if(ins_st==0){ total=parseFloat(subtotal_with_discount)+parseFloat(tax);	$("#ins").val(0); }
    $("#sb_t").val(subtotal);
    $("#sb_t_w_d").val(subtotal_with_discount);
    $("#tax").val(tax);
    $("#total").val(total);
}
function change_qty(id_bike){
	if($("#qty_"+parseInt(id_bike)).val()>=0){
		bikes_qty[id_bike]=$("#qty_"+id_bike).val();
	} else if($("#qty_"+id_bike).val()<0){
	    bikes_qty[id_bike]=0;
	    $("#qty_"+id_bike).val(0);
	}		
	total_price();
}
