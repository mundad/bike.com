/**
 * Created by Dilmurod on 01.07.2018.
 */
var a_b_count=0;
var k_b_count=0;
var t_b_count=0;
var a_b_hrs=0;
var k_b_hrs=0;
var t_b_hrs=0;
var a_b_date_in="",a_b_date_out="",k_b_date_in="",k_b_date_out="",t_b_date_in="",t_b_date_out="";
var prices=[];
var h_count=0,l_count=0,b_count=0,b_s_count=0;
var total=0,t_a=0,t_k=0,t_t=0,t_h=0,t_l=0,t_b=0,t_b_s=0,subtotal=0,tax=0;
$(document).ready(function () {
    $.get('get_prices.php',{},function (data) {
        data=JSON.parse(data);
        for(var id in data){
            prices[id]=data[id];
        }
    });
    $("#save").on("click",function () {
        total_price();
    });
    $("#adult_qty").on("change",function () {
       if($("#adult_qty").val()>=0){
           a_b_count=$("#adult_qty").val();
       } else if($("#adult_qty").val()<0){
           a_b_count=0;
           $("#adult_qty").val(0);
       }
       total_price();
    });
    $("#kids_qty").on("change",function () {
        if($("#kids_qty").val()>=0){
            k_b_count=$("#kids_qty").val();
        } else if($("#kids_qty").val()<0){
            k_b_count=0;
            $("#kids_qty").val(0);
        }
        total_price();
    });
    $("#tandem_qty").on("change",function () {
        if($("#tandem_qty").val()>=0){
            t_b_count=$("#tandem_qty").val();
        } else if($("#tandem_qty").val()<0){
            t_b_count=0;
            $("#tandem_qty").val(0);
        }
        total_price();
    });
    $("#helmet").on("change",function () {
        if($("#helmet").val()>=0){
            h_count=$("#helmet").val();
        } else if($("#helmet").val()<0){
            h_count=0;
            $("#helmet").val(0);
        }
        total_price();
    });
    $("#lock").on("change",function () {
        if($("#lock").val()>=0){
            l_count=$("#lock").val();
        } else if($("#lock").val()<0){
            l_count=0;
            $("#lock").val(0);
        }
        total_price();
    });
    $("#basket").on("change",function () {
        if($("#basket").val()>=0){
            b_count=$("#basket").val();
        } else if($("#basket").val()<0){
            b_count=0;
            $("#basket").val(0);
        }
        total_price();
    });
    $("#babyseat").on("change",function () {
        if($("#babyseat").val()>=0){
            b_s_count=$("#babyseat").val();
        } else if($("#babyseat").val()<0){
            b_s_count=0;
            $("#babyseat").val(0);
        }
        total_price();
    });
    $("#adult_hrs").on("change",function () {
        if($("#adult_hrs").val()>=0){
            a_b_hrs=$("#adult_hrs").val();
        } else if($("#adult_hrs").val()<0){
            a_b_hrs=0;
            $("#adult_hrs").val(0);
        }
        if(a_b_hrs == 0){
            $("#adult_time_out").prop('disabled',false);
            $("#adult_time_in").prop('disabled',false)
        } else if(a_b_hrs>0) {
            $("#adult_time_out").val('');
            $("#adult_time_in").val('');
            $("#adult_time_out").prop('disabled',true);
            $("#adult_time_in").prop('disabled',true);
        }
        total_price();
    });
    $("#kids_hrs").on("change",function () {
        if($("#kids_hrs").val()>0){
            k_b_hrs=$("#kids_hrs").val();
        } else if($("#kids_hrs").val()<=0){
            k_b_hrs=0;
            $("#kids_hrs").val(0);
        }
        if(k_b_hrs == 0){
            $("#kids_time_out").prop('disabled',false);
            $("#kids_time_in").prop('disabled',false);
        } else if(k_b_hrs>0) {
            $("#kids_time_out").val('');
            $("#kids_time_in").val('');
            $("#kids_time_out").prop('disabled',true);
            $("#kids_time_in").prop('disabled',true);
        }
        total_price();
    });
    $("#tandem_hrs").on("change",function () {
        if($("#tandem_hrs").val()>0){
            t_b_hrs=$("#tandem_hrs").val();
        } else if($("#tandem_hrs").val()<=0){
            t_b_hrs=0;
            $("#tandem_hrs").val(0);
        }
        if(t_b_hrs == 0){
            $("#tandem_time_out").prop('disabled',false);
            $("#tandem_time_in").prop('disabled',false);
        } else if(t_b_hrs>0) {
            $("#tandem_time_out").val('');
            $("#tandem_time_in").val('');
            $("#tandem_time_out").prop('disabled',true);
            $("#tandem_time_in").prop('disabled',true);
        }
        total_price();
    });
    $("#adult_time_out").on("change",function () {
        a_b_date_out=$("#adult_time_out").val();
        if($("#adult_time_out").val().length==0 && $("#adult_time_in").val().length==0){
            $("#adult_hrs").prop('disabled',false);
            $("#adult_time_out").prop('disabled',true);
            $("#adult_time_in").prop('disabled',true);
        } else{
            $("#adult_hrs").prop('disabled',true);
        }
    });
    $("#adult_time_in").on("change",function () {
        a_b_date_in=$("#adult_time_in").val();
        if($("#adult_time_out").val().length==0 && $("#adult_time_in").val().length==0){
            $("#adult_hrs").prop('disabled',false);
            $("#adult_time_out").prop('disabled',true);
            $("#adult_time_in").prop('disabled',true);
        } else{
            $("#adult_hrs").prop('disabled',true);
        }
        total_price();
    });
    $("#kids_time_out").on("change",function () {
        k_b_date_out=$("#kids_time_out").val();
        if($("#kids_time_out").val().length==0 && $("#kids_time_in").val().length==0){
            $("#kids_hrs").prop('disabled',false);
            $("#kids_time_out").prop('disabled',true);
            $("#kids_time_in").prop('disabled',true);
        } else{
            $("#kids_hrs").prop('disabled',true);
        }
        total_price();
    });
    $("#kids_time_in").on("change",function () {
        k_b_date_in=$("#kids_time_in").val();
        if($("#kids_time_out").val().length==0 && $("#kids_time_in").val().length==0){
            $("#kids_hrs").prop('disabled',false);
            $("#kids_time_out").prop('disabled',true);
            $("#kids_time_in").prop('disabled',true);
        } else{
            $("#kids_hrs").prop('disabled',true);
        }
        total_price();
    });
    $("#tandem_time_out").on("change",function () {
        t_b_date_out=$("#tandem_time_out").val();
        if($("#tandem_time_out").val().length==0 && $("#tandem_time_in").val().length==0){
            $("#tandem_hrs").prop('disabled',false);
            $("#tandem_time_out").prop('disabled',true);
            $("#tandem_time_in").prop('disabled',true);
        } else{
            $("#tandem_hrs").prop('disabled',true);
        }
        total_price();
    });
    $("#tandem_time_in").on("change",function () {
        t_b_date_in=$("#tandem_time_in").val();
        if($("#tandem_time_out").val().length==0 && $("#tandem_time_in").val().length==0){
            $("#tandem_hrs").prop('disabled',false);
            $("#tandem_time_out").prop('disabled',true);
            $("#tandem_time_in").prop('disabled',true);
        } else{
            $("#tandem_hrs").prop('disabled',true);
        }
        total_price();
    });
});
function total_price() {
    t_a=0;
    t_k=0;
    t_t=0;
    t_h=0;
    t_l=0;
    t_b=0;
    t_b_s=0;
    if(a_b_count>0){
        if(a_b_hrs>0){
            t_a=(parseInt(a_b_count)*parseInt(a_b_hrs)*parseFloat(prices['a_b_hrs']));
        } else if(a_b_hrs==0){
            if(a_b_date_out.length==10 && a_b_date_in.length==10){
                var date1=new Date(a_b_date_in);
                var date2=new Date(a_b_date_out);
                var day=(date1 - date2) / (1000*60*60*24);
                t_a=(parseInt(a_b_count)*parseInt(day)*parseFloat(prices['a_b_day']));
            } else if(a_b_date_out.length==0 && a_b_date_in.length==0){
                t_a=0;
            }
        }
    }
    if(k_b_count>0){
        if(k_b_hrs>0){
            t_k=(parseInt(k_b_count)*parseInt(k_b_hrs)*parseFloat(prices['k_b_hrs']));
        } else if(k_b_hrs==0){
            if(k_b_date_out.length==10 && k_b_date_in.length==10){
                var date1=new Date(k_b_date_in);
                var date2=new Date(k_b_date_out);
                var day=(date1 - date2) / (1000*60*60*24);
                t_k=(parseInt(k_b_count)*parseInt(day)*parseFloat(prices['k_b_day']));
            } else if(k_b_date_out.length==0 && k_b_date_in.length==0){
                t_k=0;
            }
        }
    }
    if(t_b_count>0){
        if(t_b_hrs>0){
            t_t=(parseInt(t_b_count)*parseInt(t_b_hrs)*parseFloat(prices['t_b_hrs']));
        } else if(t_b_hrs==0){
            if(t_b_date_out.length==10 && t_b_date_in.length==10){
                var date1=new Date(t_b_date_in);
                var date2=new Date(t_b_date_out);
                var day=(date1 - date2) / (1000*60*60*24);
                t_t=(parseInt(t_b_count)*parseInt(day)*parseFloat(prices['t_b_day']));
            } else if(t_b_date_out.length==0 && t_b_date_in.length==0){
                t_t=0;
            }
        }
    }
    if(h_count>0){
        t_h=(parseInt(h_count)*parseFloat(prices['helmet']));
    }
    if(l_count>0){
        t_l=(parseInt(l_count)*parseFloat(prices['lock']));
    }
    if(b_count>0){
        t_b=(parseInt(b_count)*parseFloat(prices['basket']));
    }
    if(b_s_count>0){
        t_b_s=(parseInt(b_s_count)*parseFloat(prices['baby_seat']));
    }
    subtotal=t_a+t_k+t_t+t_h+t_l+t_b+t_b_s;
    tax=parseFloat(((subtotal/100)*8.875).toFixed(2));
    total=subtotal+tax;
    /*tax=(subtotal/100)*8.875;
    total=subtotal+tax;*/
    //alert(subtotal);
    $("#sb_t").val(subtotal);
    $("#tax").val(tax);
    $("#total").val(total);

}