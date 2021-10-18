    $("#profile").on('change', function () {
        var val = $(this).val();
        var htmlOutput = '';
        if (val != 0) {
            getUser(val);
        }
        else{
            $('.userProfile').html('');
        }
    });

    function getUser(val) {
        //alert(val);
        
        $.get('user/getProfileUser/' + val, function (data) {
            var list = '';
            if (data != '') {
                list += '<label class="col-sm-2 control-label">Users <span class="error"> *</span></label><td>';
                list += '<div class="col-sm-7"><select name="user" class="textfield width_auto form-control" >';
                list += '<option value="0">All User</option>';
                if (val) {
                    for (x in data) {
                    if(data[x].username != ''){
                        list += "<option value='" + data[x].user_id + "' ";
                        list += data[x].user_id == USER_ID ? 'selected' : '';
                        list += ">" + data[x].username + "</option>";
                        }
                    }
                }
                list += '</select></div>';                
                $('.userProfile').html(list);
            }
            else{
                $('.userProfile').html(list);
            }  
            
        }, 'json'
                );
    }


    /* $("#profile_id").on('change', function () {
     alert()
     cnt = 1;
     var v = $(this).val();
     var htmlcontent = '';
     if (v == 'product') {
     htmlcontent += addproduct(0);
     $('.coupon_type, .coupon_type_value, .min_order_value').hide();
     }
     if (v == 'category') {
     htmlcontent += '<div class="category">';
     htmlcontent += category(0, '');
     htmlcontent += '</div>';
     $('.coupon_type, .coupon_type_value, .min_order_value').show();
     }
     
     if (v == 'basket') {
     $('.coupon_type, .coupon_type_value, .min_order_value').show();
     }
     $('#coupon_add_on').html(htmlcontent);
     }); */

    $("#uses_term").on('change', function () {
        var t = $(this).val();
        if (t == 'onetime') {
            $('.uses_limit').hide();
        } else {
            $('.uses_limit').show();
        }
    });

    $("#coupon_on").on('change', function () {
        //alert()
        cnt = 1;
        var v = $(this).val();
        var htmlcontent = '';
        if (v == 'product') {
            htmlcontent += addproduct(0);
            $('.coupon_type, .coupon_type_value, .min_order_value').hide();
        }
        if (v == 'category') {
            htmlcontent += '<div class="category">';
            htmlcontent += category(0, '');
            htmlcontent += '</div>';
            $('.coupon_type, .coupon_type_value, .min_order_value').show();
        }

        if (v == 'basket') {
            $('.coupon_type, .coupon_type_value, .min_order_value').show();
        }
        $('#coupon_add_on').html(htmlcontent);
    });

    function category(count, cid) {
        var data = CATEGORY;
        if (count === 0) {
            var list = '<select class="textfield width_auto"   name="category">';
        } else {
            var list = '<select class="textfield width_auto" name="category[]" onchange="OnchangProduct(this)"  id="' + count + '">';
        }
        list += "<option value=''>Select Cetegory</option>";
        for (x in data.id) {
            list += "<option value='" + data.id[x] + "'";
            list += data.id[x] === cid ? 'selected' : '';
            list += ">" + data.name[x] + "</option>";
        }
        list += '</select>';
        return list;
    }

    function addproduct(pro) {
        //alert(JSON.stringify(pro,null,4));
        var htmcont = '';
        var bv = pro === 0 ? '' : pro.basket_value;
        var fq = pro === 0 ? '' : pro.free_qty;
        var cid = pro === 0 ? '' : pro.category_id;
        var pid = pro === 0 ? '' : pro.product_id;
        var pctype = pro === 0 ? '' : pro.pro_coupon_type;
        var freeValuePercentage = '';
        //alert(pctype);

        htmcont += '<div class="prostyle  product' + cnt + '">';
        htmcont += '<div class="procat" >' + category(cnt, cid) + '</div>';
        htmcont += '<div class="propro_' + cnt + '">' + getproduct(cnt, pid, cid) + '</div>';
        htmcont += '<div><input name="basket_value[]" value="' + bv + '" placeholder="Minimum basket value" class="textfield" type="text" requied></div>';

        if(pctype != ''){
            htmcont += '<div class="procoupntype_' + cnt + '"><select name="procoupntype[]"  onchange="productType(this)" id="dp_' + cnt + '"><option value="" >--Select Coupon Type--</option>';
            if(pctype == 'free') {
                htmcont += '<option selected="true" value="free" >Free</option>';
            }   else {
                htmcont += '<option value="free" >Free</option>';            
            }
            if(pctype == 'value') {
                htmcont += '<option selected="true" value="value" >Value</option>';
            }   else {
                htmcont += '<option value="value" >Value</option>';
            }
            if(pctype == 'percentage') {
                htmcont += '<option selected="true" value="percentage" >Percentage</option>';
            }   else {
                htmcont += '<option value="percentage" >Percentage</option>';
            }
            htmcont += '</select>';
        }
        else{
            htmcont += '<div class="procoupntype_' + cnt + '"><select name="procoupntype[]"  onchange="productType(this)"><option value="">--Select Coupon Type--</option><option value="free">Free</option><option value="value">Value</option><option value="percentage">Percentage</option></select>';
        }

        <!-- freeValuePercentage -->
        htmcont += getTypeHtml(pctype,pro.pro_coupon_type_value,cnt);
        htmcont += '</div>';
        htmcont += (cnt === 1) ? '<div class="coupon_sign" onclick="addproduct(' + 0 + ')"> <img src="' + base_url + 'images/plus.png" alt="+" /> </div>' : '<div class="coupon_sign" onclick="removeProduct(' + cnt + ')"> <img src="' + base_url + 'images/minus.png" alt=" - " /> </div>';
        htmcont += '</div>';
        if (pro === 0) {
            if (cnt === 1) {
                cnt++;
                return htmcont;
            } else {
                $('.product1').after(htmcont);
                cnt++;
            }
        } else {
            cnt++;
            return htmcont;
        }

    }


    function removeProduct(pcnt) {
        $('.product' + pcnt).remove();
    }

    function getproduct(count, pid, cid) {
        var list = '';
        $.get('catalog/product/products_list/' + cid, function (data) {

            list += '<select name="product[]" class="textfield width_auto" >';
            list += '<option >Select Prodct</optio>';
            if (cid) {
                for (x in data) {
                    list += "<option value='" + data[x].pid + "' ";
                    list += data[x].pid == pid ? 'selected' : '';
                    list += ">" + data[x].pname + "</option>";
                }
            }
            list += '</select>';

            $('.propro_' + count).html(list);
        }, 'json');
        return list;
    }

    function OnchangProduct(sel) {
        var catid = $(sel).attr("id");
        var catval = $(sel).val();
        $.get('catalog/product/listAll/' + catval, function (data) {
            var list = '';
            list += '<select name="product[]" class="textfield width_auto">';
            for (x in data) {

                list += "<option value='" + data[x].pid + "'>" + data[x].pname + "</option>";
            }
            list += '</select>';
            $('.propro_' + catid).html(list);
        }, 'json');
    }

    function getTypeHtml(type,value,count){
        var htmcont = '';
        if(type == 'free') {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="free_qty[]" value="' + value + '" placeholder="Free quantity" class="textfield" type="text" required></div>';        
        }
        else {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="free_qty[]" type="hidden"></div>';                
        }
        if(type == 'value') {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="value[]" value="' + value + '" placeholder="Value" class="textfield" type="text" required></div>';
        }
        else {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="value[]" placeholder="Value" type="hidden"></div>';
        }
        if(type == 'percentage') {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="percentage[]" value="' + value + '" placeholder="Percentage" class="textfield" type="text"></div>';
        }
        else {
            htmcont += '<div class="prfield_procoupntype_'+count+'"><input name="percentage[]" placeholder="Percentage" type="hidden"></div>';
        }
        return htmcont;
    }

    function productType(val){
        var v = $(val).val();
        var c = $(val).parent().attr('class');
        var f = $("." + c).find(".prfield_"+ c);
        html = '';
        if(v === 'free' ){
            html = '<div class="prfield_'+ c +'"><input name="free_qty[]" value="" placeholder="Free quantity " class="textfield" type="text" required></div>';
            $("." + c).append(html);  
            if(f){
                $(f).remove();
            }          
            
        }
        else{
            html = '<div class="prfield_'+ c +'"><input name="free_qty[]" value="" placeholder="Free quantity " class="textfield" type="hidden">';
            $("." + c).append(html);  
            if(f){
                $(f).remove();
            }   
        }
        
        if(v === 'value'){
            html = '<div class="prfield_'+ c +'"><input name="value[]" value="" placeholder="Value" class="textfield" type="text" required></div>';
            $("." + c).append(html);
            if(f){
                $(f).remove();
            }  
        }
        else{
            html = '<div class="prfield_'+ c +'"><input name="value[]" value="" placeholder="Value" class="textfield" type="hidden"></div>';
            $("." + c).append(html);
            if(f){
                $(f).remove();
            }  
        }

        if(v === 'percentage' ){
            html = '<div class="prfield_'+ c +'"><input name="percentage[]" value="" placeholder="Percentage" class="textfield" type="text" required></div>';
            $("." + c).append(html);
            if(f){
                $(f).remove();
            }  
        }
        else{
            html = '<div class="prfield_'+ c +'"><input name="percentage[]" value="" placeholder="Percentage" class="textfield" type="hidden"></div>';
            $("." + c).append(html);
            if(f){
                $(f).remove();
            }  
        }
        /*else{
            $(f).remove();
        }*/

    }