$(document).ready(function(){
	$(".open-category").click(function () {
		$('#category-slider').toggle('slide', { direction: 'right' }, 700);
	});
	$(".open-subcategory").click(function () {
		$('#subcategory-slider').toggle('slide', { direction: 'right' }, 700);
	});
	$(document).on('click', function(e){
		if (!$(e.target).is(".open-category, .cat-child") && !$(e.target).parents("#category-slider").size() && $('#category-slider').is(':visible')) {
			$('#category-slider').toggle('slide', { direction: 'right' }, 700);
		}
		if (!$(e.target).is(".open-subcategory, .cat-child") && !$(e.target).parents("#subcategory-slider").size() && $('#subcategory-slider').is(':visible')) {
			$('#subcategory-slider').toggle('slide', { direction: 'right' }, 700);
		}
	});
	$('.po').popover({html: true, placement: 'right', trigger: 'click'}).popover();
	$('#inlineCalc').calculator({layout: ['_%+-CABS','_7_8_9_/','_4_5_6_*','_1_2_3_-','_0_._=_+'], showFormula:true});
	$('.calc').click(function(e) { e.stopPropagation();});
});
$(document).ready(function () {

// Order level shipping and discoutn localStorage
if (posdiscount = localStorage.getItem('posdiscount')) {
	$('#posdiscount').val(posdiscount);
}
if (posdiscount_id = localStorage.getItem('posdiscount_id')) {
	$('#posdiscount_id').val(posdiscount_id);
}
if (posdiscount_name = localStorage.getItem('posdiscount_name')) {
	$('#posdiscount_name').text(posdiscount_name);
}

if (poscoupon = localStorage.getItem('poscoupon')) {
	$('#poscoupon').val(poscoupon);
}
if (poscoupon_id = localStorage.getItem('poscoupon_id')) {
	$('#poscoupon_id').val(poscoupon_id);
}
if (poscoupon_name = localStorage.getItem('poscoupon_name')) {
	$('#poscoupon_name').text(poscoupon_name);
}

$(document).on('change', '#ppostax2', function () {
	localStorage.setItem('postax2', $(this).val());
	$('#postax2').val($(this).val());
});

if (postax2 = localStorage.getItem('postax2')) {
	$('#postax2').val(postax2);
}

$(document).on('blur', '#sale_note', function () {
	localStorage.setItem('posnote', $(this).val());
	$('#sale_note').val($(this).val());
});

if (posnote = localStorage.getItem('posnote')) {
	$('#sale_note').val(posnote);
}

$(document).on('blur', '#staffnote', function () {
	localStorage.setItem('staffnote', $(this).val());
	$('#staffnote').val($(this).val());
});

if (staffnote = localStorage.getItem('staffnote')) {
	$('#staffnote').val(staffnote);
}


	/* ----------------------
	 * Order Discount Handler
	 * ---------------------- */
	$("#ppdiscount").click(function(e) {
	 	e.preventDefault();
	 	var dval = $('#posdiscount').val() ? $('#posdiscount').val() : '0';
	 	var ds_id = $('#discount_id').val();
	 	$('#order_discount_input').val(dval);
	 	$('#discount_id').val(ds_id);
	 	$('#dsModal').modal();
	 	if(ds_id != ''){
	 		var ds = $('#order_discount_input').val();
	 			var ds_id = $('#discount_id').val();
	 			var ds_price = $('#gtotaltext').val();
	 			var ds_total = $('#totaltext').val();
	 			var ds_non_total = $('#totalnontext').val();
	 			var ds_tax = $('#taxtext').val();
	 			var ds_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/discount_suggestions',
					dataType: "json",
					data: { term: ds_id, customer_id:ds_customer_id, price:ds_price, total:ds_total, tax:ds_tax, non_total:ds_non_total },
					success: function (data) {
						if(data.status == 1){
							localStorage.removeItem('posdiscount');
			 				localStorage.setItem('posdiscount', ds);
			 				localStorage.removeItem('posdiscount_id');
			 				localStorage.setItem('posdiscount_id', ds_id);
			 				localStorage.removeItem('posdiscount_name');
			 				localStorage.setItem('posdiscount_name', data.name);
			 				loadItems();
							$('#order_discount_input').val(data.value);
	 						$('#posdiscount_name').text(data.name);
	 						
						}else
						{
							alert(data.fail);
							$('#dsModal').modal('hide');
						}			
					} 	
				});
	 	}
	});
	$('#dsModal').on('shown.bs.modal', function() {
	 	$(this).find('#order_discount_input').select().focus();
	 	$('#order_discount_input').bind('keypress', function(e) {
	 		if (e.keyCode == 13) {
	 			e.preventDefault();
	 			var ds = $('#order_discount_input').val();
	 			var ds_id = $('#discount_id').val();
	 			if (is_valid_discount(ds)) {
	 				$('#posdiscount').val(ds);
	 				localStorage.removeItem('posdiscount');
	 				localStorage.setItem('posdiscount', ds);
	 				localStorage.removeItem('posdiscount_id');
	 				localStorage.setItem('posdiscount_id', ds_id);
	 				
	 				loadItems();
	 			} else {
	 				bootbox.alert(lang.unexpected_value);
	 			}
	 			$('#dsModal').modal('hide');
	 		}
	 	});
	});
	$('#discount_id').on('change', function(e) {
	 			e.preventDefault();
	 			var ds = $('#order_discount_input').val();
	 			var ds_id = $('#discount_id').val();
	 			var ds_price = $('#gtotaltext').val();
	 			var ds_total = $('#totaltext').val();
	 			var ds_non_total = $('#totalnontext').val();
	 			var ds_tax = $('#taxtext').val();
	 			var ds_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/discount_suggestions',
					dataType: "json",
					data: { term: ds_id, customer_id:ds_customer_id, price:ds_price, total:ds_total, tax:ds_tax, non_total:ds_non_total },
					success: function (data) {
						if(data.status == 1){
							loadItems();
						$('#order_discount_input').val(data.value);
						$('#posdiscount_name').text(data.name);
	 		
						}else
						{
							alert(data.fail);
						}			
					} 	
				});
	 			// if (is_valid_discount(ds)) {
	 			// 	$('#posdiscount').val(ds);
	 			
	 			// } else {
	 			// 	bootbox.alert(lang.unexpected_value);
	 			// }
	 			// $('#dsModal').modal('hide');
	 		
	});
	 	
	$(document).on('click', '#updateOrderDiscount', function() {
	 	var ds = $('#order_discount_input').val() ? $('#order_discount_input').val() : '0';
	 	var ds_id = $('#discount_id').val();
	 	var ds_price = $('#gtotaltext').val();
	 			var ds_total = $('#totaltext').val();
	 			var ds_non_total = $('#totalnontext').val();
	 			var ds_tax = $('#taxtext').val();
	 			var ds_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/discount_suggestions',
					dataType: "json",
					data: { term: ds_id, customer_id:ds_customer_id, price:ds_price, total:ds_total, tax:ds_tax, non_total:ds_non_total },
					success: function (data) {
						if(data.status == 1){
							if (is_valid_discount(ds)) {
						 		$('#posdiscount').val(ds);
						 		$('#posdiscount_id').val(ds_id);
						 		$('#posdiscount_name').text(data.name);
						 		
						 		localStorage.removeItem('posdiscount');
						 		localStorage.setItem('posdiscount', ds);
						 		localStorage.removeItem('posdiscount_id');
						 		localStorage.setItem('posdiscount_id', ds_id);
						 		localStorage.removeItem('posdiscount_name');
						 		localStorage.setItem('posdiscount_name', data.name);
						 		loadItems();
						 	} else {
						 		bootbox.alert(lang.unexpected_value);
						 	}		 		
						}else
						{
							alert(data.fail);
						}			
					} 	
				});
	 		
	 	$('#dsModal').modal('hide');
	});

	/* ----------------------
	 * Coupon Discount Handler
	 * ---------------------- */
	$("#ppcoupon").click(function(e) {
	 	e.preventDefault();
	 	var cval = $('#poscoupon').val() ? $('#poscoupon').val() : '0';
	 	var cop_id = $('#coupon_id').val();
	 	$('#coupon_input').val(cval);
	 	$('#coupon_id').val(cop_id);
	 	$('#couponModal').modal();
	 	if(cop_id != ''){
	 		var cop = $('#coupon_input').val();
	 			var cop_id = $('#coupon_id').val();
	 			var cop_price = $('#gtotaltext').val();
	 			var cop_total = $('#totaltext').val();
	 			var cop_non_total = $('#totalnontext').val();
	 			var cop_tax = $('#taxtext').val();
	 			var cop_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/coupon_suggestions',
					dataType: "json",
					data: { term: cop_id, customer_id:cop_customer_id, price:cop_price, total:cop_total, tax:cop_tax, non_total:cop_non_total },
					success: function (data) {
						if(data.status == 1){
							localStorage.removeItem('poscoupon');
			 				localStorage.setItem('poscoupon', cop);
			 				localStorage.removeItem('poscoupon_id');
			 				localStorage.setItem('poscoupon_id', cop_id);
			 				localStorage.removeItem('poscoupon_name');
			 				localStorage.setItem('poscoupon_name', data.card_no);
			 				loadItems();
							$('#coupon_input').val(data.value);
	 						$('#poscoupon_name').text(data.name);
	 						
						}else
						{
							alert(data.fail);
							$('#couponModal').modal('hide');
						}			
					} 	
				});
	 	}
	});
	$('#couponModal').on('shown.bs.modal', function() {
	 	$(this).find('#coupon_input').select().focus();
	 	$('#coupon_input').bind('keypress', function(e) {
	 		if (e.keyCode == 13) {
	 			e.preventDefault();
	 			var cop = $('#coupon_input').val();
	 			var cop_id = $('#coupon_id').val();
	 			if (is_valid_discount(cop)) {
	 				$('#poscoupon').val(ds);
	 				localStorage.removeItem('poscoupon');
	 				localStorage.setItem('poscoupon', cop);
	 				localStorage.removeItem('poscoupon_id');
	 				localStorage.setItem('poscoupon_id', cop_id);
	 				
	 				loadItems();
	 			} else {
	 				bootbox.alert(lang.unexpected_value);
	 			}
	 			$('#couponModal').modal('hide');
	 		}
	 	});
	});
	$('#coupon_id').on('change', function(e) {
	 			e.preventDefault();
	 			var cop = $('#coupon_input').val();
	 			var cop_id = $('#coupon_id').val();
	 			var cop_price = $('#gtotaltext').val();
	 			var cop_total = $('#totaltext').val();
	 			var cop_non_total = $('#totalnontext').val();
	 			var cop_tax = $('#taxtext').val();
	 			var cop_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/coupon_suggestions',
					dataType: "json",
					data: { term: cop_id, customer_id:cop_customer_id, price:cop_price, total:cop_total, tax:cop_tax, non_total:cop_non_total },
					success: function (data) {
						if(data.status == 1){
						loadItems();
						$('#coupon_input').val(data.value);
						$('#poscoupon_name').text(data.name);
	 		
						}else
						{
							alert(data.fail);
						}			
					} 	
				});
	});
	 	
	$(document).on('click', '#updateCoupon', function() {
	 	var cop = $('#coupon_input').val() ? $('#coupon_input').val() : '0';
	 	var cop_id = $('#coupon_id').val();
	 	var cop_price = $('#gtotaltext').val();
	 			var cop_total = $('#totaltext').val();
	 			var cop_non_total = $('#totalnontext').val();
	 			var cop_tax = $('#taxtext').val();
	 			var cop_customer_id = $('#poscustomer').val();
	 			$.ajax({
					type: 'get',
					url: site.base_url+'pos/coupon_suggestions',
					dataType: "json",
					data: { term: cop_id, customer_id:cop_customer_id, price:cop_price, total:cop_total, tax:cop_tax, non_total:cop_non_total },
					success: function (data) {
						if(data.status == 1){
							if (is_valid_discount(cop)) {
						 		$('#poscoupon').val(cop);
						 		$('#poscoupon_id').val(cop_id);
						 		$('#poscoupon_name').text(data.name);
						 		
						 		localStorage.removeItem('poscoupon');
						 		localStorage.setItem('poscoupon', cop);
						 		localStorage.removeItem('poscoupon_id');
						 		localStorage.setItem('poscoupon_id', cop_id);
						 		localStorage.removeItem('poscoupon_name');
						 		localStorage.setItem('poscoupon_name', data.name);
						 		loadItems();
						 	} else {
						 		bootbox.alert(lang.unexpected_value);
						 	}		 		
						}else
						{
							alert(data.fail);
						}			
					} 	
				});
	 		
	 	$('#couponModal').modal('hide');
	});
	/* ----------------------
	 * Order Tax Handler
	 * ---------------------- */
	 $("#pptax2").click(function(e) {
	 	e.preventDefault();
	 	var postax2 = localStorage.getItem('postax2');
	 	$('#order_tax_input').select2('val', postax2);
	 	$('#txModal').modal();
	 });
	 $('#txModal').on('shown.bs.modal', function() {
	 	$(this).find('#order_tax_input').select2('focus');
	 });
	 $('#txModal').on('hidden.bs.modal', function() {
	 	var ts = $('#order_tax_input').val();
	 	$('#postax2').val(ts);
	 	localStorage.setItem('postax2', ts);
	 	loadItems();
	 });
	 $(document).on('click', '#updateOrderTax', function () {
	 	var ts = $('#order_tax_input').val();
	 	$('#postax2').val(ts);
	 	localStorage.setItem('postax2', ts);
	 	loadItems();
	 	$('#txModal').modal('hide');
	 });


	 $(document).on('change', '.rserial', function () {
	 	var item_id = $(this).closest('tr').attr('data-item-id');
	 	positems[item_id].row.serial = $(this).val();
	 	localStorage.setItem('positems', JSON.stringify(positems));
	 });

// If there is any item in localStorage
if (localStorage.getItem('positems')) {
	loadItems();
}

	// clear localStorage and reload
	$('#reset').click(function (e) {
		bootbox.confirm(lang.r_u_sure, function (result) {
			if (result) {
				if (localStorage.getItem('positems')) {
					localStorage.removeItem('positems');
				}
				if (localStorage.getItem('group')) {
					localStorage.removeItem('group');
				}
				if (localStorage.getItem('posdiscount')) {
					localStorage.removeItem('posdiscount');
				}
				if (localStorage.getItem('poscoupon')) {
					localStorage.removeItem('poscoupon');
				}
				if (localStorage.getItem('poscoupon_name')) {
					localStorage.removeItem('poscoupon_name');
				}
				if (localStorage.getItem('postax2')) {
					localStorage.removeItem('postax2');
				}
				if (localStorage.getItem('posshipping')) {
					localStorage.removeItem('posshipping');
				}
				if (localStorage.getItem('posref')) {
					localStorage.removeItem('posref');
				}
				if (localStorage.getItem('poswarehouse')) {
					localStorage.removeItem('poswarehouse');
				}
				if (localStorage.getItem('posnote')) {
					localStorage.removeItem('posnote');
				}
				if (localStorage.getItem('posinnote')) {
					localStorage.removeItem('posinnote');
				}
				if (localStorage.getItem('poscustomer')) {
					localStorage.removeItem('poscustomer');
				}
				if (localStorage.getItem('poscurrency')) {
					localStorage.removeItem('poscurrency');
				}
				if (localStorage.getItem('posdate')) {
					localStorage.removeItem('posdate');
				}
				if (localStorage.getItem('posstatus')) {
					localStorage.removeItem('posstatus');
				}
				if (localStorage.getItem('posbiller')) {
					localStorage.removeItem('posbiller');
				}
				if (localStorage.getItem('posdiscount_id')) {
					localStorage.removeItem('posdiscount_id');
				}
				if (localStorage.getItem('posdiscount_name')) {
					localStorage.removeItem('posdiscount_name');
				}
				if (localStorage.getItem('poscoupon_id')) {
					localStorage.removeItem('poscoupon_id');
				}
				
				$('#modal-loading').show();
				//location.reload();
				window.location.href = site.base_url+"pos";
			}
		});
});

// save and load the fields in and/or from localStorage

$('#poswarehouse').change(function (e) {
	localStorage.setItem('poswarehouse', $(this).val());
});
if (poswarehouse = localStorage.getItem('poswarehouse')) {
	$('#poswarehouse').select2('val', poswarehouse);
}

	//$(document).on('change', '#posnote', function (e) {
		$('#posnote').redactor('destroy');
		$('#posnote').redactor({
			buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
			formattingTags: ['p', 'pre', 'h3', 'h4'],
			minHeight: 100,
			changeCallback: function (e) {
				var v = this.get();
				localStorage.setItem('posnote', v);
			}
		});
		if (posnote = localStorage.getItem('posnote')) {
			$('#posnote').redactor('set', posnote);
		}

		$('#poscustomer').change(function (e) {
			localStorage.setItem('poscustomer', $(this).val());
			var cust_id = $(this).val();
			$.ajax({
                    type: "get", async: false,
                    url: site.base_url+'customers/getCustomer/' + $(this).val(),
                    dataType: "json",
                    success: function (data) {
						window.customerData = data;
						var customerGroupName = $("<div>").html(data[0].customer_group_name).text();
                        $("#item-list1").html("<div><p>Name : "+data[0].prefix +" "+ data[0].text+"</p><p>DOB : "+
						data[0].dob+"</p><p>Anniversary : "+data[0].anniversary+"</p><p>Phone : "+
						data[0].phone+"</p><p>Customer : "+data[0].customer_group_name+"</p><p>Email : "+
						data[0].email+"</p><p>Gender : "+data[0].gender+"</p><p>Whatsapp : "+
						data[0].whatsapp+"</p>"+(customerGroupName.toLowerCase() == "member" ? "<b><p>Start Date: " + 
						data[0].cf1 + "</p></b>" : "") + (customerGroupName.toLowerCase() == "member" ? "<b><p>End Date: " + 
						data[0].cf2 + "</p></b>" : "") + (customerGroupName.toLowerCase() == "member" ? "<b><p>Expires In : " + data[0].expiresIn + " Days</p></b>" :"") +"<br><a class='btn btn-success' style='width:100%' href='"+
						site.base_url+"customers/edit/"+data[0].id+"<br><a class='btn btn-success' style='width:100%' href='"+
						site.base_url+"customers/edit/"+data[0].id+"' data-toggle='modal' data-target='#myModal'>Edit</a><div class='item-list-sales'></div><div class='item-customer-list-sales'></div><div class='item-list-coupons'></div></div>");

                        if(data[0].sales != false){
                            var sales = data[0].sales;
                            var sale_count = sales.length;
                            s = 0;
							$(".item-list-sales").append("<h2 class='text-center'>View Previous sales</h2>");
                            $.each(sales, function () {
                                $(".item-list-sales").append("<div class='col-md-6' style='margin-bottom:2px'><a class='btn btn-warning' style='width:100%' target='_blank' href='"+site.base_url+"pos/view/"+sales[s].id+"/1' data-toggle='modal' data-target='#myModal'>Sales "+(s+1)+"</a></div>");
                                s++;
                            });
                            
                            $(".item-customer-list-sales").append("<br><a class='btn btn-success' target='_blank' style='width:100%' href='"+site.base_url+"reports/customer_report/"+cust_id+"' >View More</a>");
                            
                        }
                        if(data[0].coupons != false){
                            var coupons = data[0].coupons;

                            c = 0;
                            $.each(coupons, function () {
                                console.log(coupons[c].id);
                                
                                $(".item-list-coupons").append("<br><table class='table table-bordered table-striped table-responsive'><tr><th>Coupon</th><th>Value</th><th>Balance</th><th>Expiry Date</th></tr><tr><td>"+coupons[c].card_no+"</td><td>"+parseFloat(coupons[c].value)+"</td><td>"+parseFloat(coupons[c].balance)+"</td><td>"+coupons[c].expiry+"</td></tr></table>");
                                c++;
                            });
                                   
                        }
                        if(data[0].wallets != false){
                            var wallets = data[0].wallets;

                            w = 0;
                            $.each(wallets, function () {
                                console.log(wallets[w].id);
                                
                                $(".item-list-wallets").html("<br><table class='table table-bordered table-striped table-responsive'><tr><th>Wallet Amount</th></tr><tr><td>"+parseFloat(wallets[w].award_points)+"</td></tr></table>");
                                w++;
                            });
                                   
                        }
                        
                        if(data[0].appointments != false){
                            var appointments = data[0].appointments;

                            a = 0;
                            $.each(appointments, function () {
                                console.log(appointments[a].id);
                                
                                $(".item-list-appointements").html("<br><table class='table table-bordered table-striped table-responsive'><tr><th>Date</th><th>Stylist</th></tr><tr><td>"+appointments[a].date+"</td><td>"+appointments[a].staff+"</td></tr></table>");
                                a++;
                            });
                                   
                        }
                        
                        
                    }
                });
		});


// prevent default action usln enter
$('body').bind('keypress', function (e) {
	if (e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});

// Order tax calculation
if (site.settings.tax2 != 0) {
	$('#postax2').change(function () {
		localStorage.setItem('postax2', $(this).val());
		loadItems();
		return;
	});
}

// Order discount calculation
var old_posdiscount;
$('#posdiscount').focus(function () {
	old_posdiscount = $(this).val();
}).change(function () {
	var new_discount = $(this).val() ? $(this).val() : '0';
	if (is_valid_discount(new_discount)) {
		localStorage.removeItem('posdiscount');
		localStorage.setItem('posdiscount', new_discount);
		loadItems();
		return;
	} else {
		$(this).val(old_posdiscount);
		bootbox.alert(lang.unexpected_value);
		return;
	}

});

// Coupon discount calculation
var old_poscoupon;
$('#poscoupon').focus(function () {
	old_poscoupon = $(this).val();
}).change(function () {
	var new_coupon = $(this).val() ? $(this).val() : '0';
	if (is_valid_coupon(new_coupon)) {
		localStorage.removeItem('poscoupon');
		localStorage.setItem('poscoupon', new_coupon);
		loadItems();
		return;
	} else {
		$(this).val(old_poscoupon);
		bootbox.alert(lang.unexpected_value);
		return;
	}

});
	
	/* ----------------------
	 * Delete Row Method
	 * ---------------------- */
	 var pwacc = false;
	 $(document).on('click', '.posdel', function () {
	 	var row = $(this).closest('tr');
	 	var item_id = row.attr('data-item-id');
	 	// if(localStorage.getItem('group') == 5){
	 	// 	localStorage.removeItem('posdiscount');
			// localStorage.setItem('posdiscount', '10%');
			// localStorage.removeItem('posdiscount_id');
			// localStorage.setItem('posdiscount_id', '5');
			// $("#posdiscount_name").text('Member Discount');
			// localStorage.removeItem('posdiscount_name');
			// localStorage.setItem('posdiscount_name', 'Member Discount');
			
			
	 	// }else
	 	// {
	 		localStorage.removeItem('posdiscount');
			localStorage.setItem('posdiscount', 0);
			localStorage.removeItem('posdiscount_id');
			localStorage.setItem('posdiscount_id', '');
			localStorage.removeItem('posdiscount_name');
			localStorage.setItem('posdiscount_name', '');
			$("#posdiscount_name").text('');
			
			localStorage.removeItem('poscoupon');
			localStorage.setItem('poscoupon', 0);
			localStorage.removeItem('poscoupon_id');
			localStorage.setItem('poscoupon_id', '');
			localStorage.removeItem('poscoupon_name');
			localStorage.setItem('poscoupon_name', '');
			$("#poscoupon_name").text('');
			
	
	 	// }
		
	 	if(protect_delete == 1) {
	 		var boxd = bootbox.dialog({
	 			title: "<i class='fa fa-key'></i> Pin Code",
	 			message: '<input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control"> ',
	 			buttons: {
	 				success: {
	 					label: "<i class='fa fa-tick'></i> OK",
	 					className: "btn-success verify_pin",
	 					callback: function () {

	 						var pos_pin = md5($('#pos_pin').val());
	 						if(pos_pin == pos_settings.pin_code) {
	 							delete positems[item_id];
	 							row.remove();
	 							if(positems.hasOwnProperty(item_id)) { } else {
	 								localStorage.setItem('positems', JSON.stringify(positems));
	 								loadItems();
	 							}
	 						} else {
	 							bootbox.alert('Wrong Pin Code');
	 						}
	 					}
	 				}
	 			}
	 		});
	 		boxd.on("shown.bs.modal", function() {
	 			$( "#pos_pin" ).focus().keypress(function(e) {
	 				if (e.keyCode == 13) {
	 					e.preventDefault();
	 					$('.verify_pin').trigger('click');
	 					return false;
	 				}
	 			});
	 		});
	 	} else {
	 		delete positems[item_id];
	 		row.remove();
	 		if(positems.hasOwnProperty(item_id)) { } else {
	 			localStorage.setItem('positems', JSON.stringify(positems));
	 			loadItems();
	 		}
	 	}
	 	return false;
	 });

	/* -----------------------
	 * Edit Row Modal Hanlder
	 ----------------------- */
	 $(document).on('click', '.edit', function () {
		var row = $(this).closest('tr');
		var row_id = row.attr('id');
		item_id = row.attr('data-item-id');
		item = positems[item_id];
		var qty = row.children().children('.rquantity').val(),
		product_option = row.children().children('.roption').val(),
		unit_price = formatDecimal(row.children().children('.realuprice').val()),
		discount = row.children().children('.rdiscount').val();
		var net_price = unit_price;
		$('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
		if (site.settings.tax1) {
			$('#ptax').select2('val', item.row.tax_rate);
	 		$('#old_tax').val(item.row.tax_rate);
	 		var item_discount = 0, ds = discount ? discount : '0';
	 		if (ds.indexOf("%") !== -1) {
	 			var pds = ds.split("%");
	 			if (!isNaN(pds[0])) {
	 				item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
	 			} else {
	 				item_discount = parseFloat(ds);
	 			}
	 		} else {
	 			item_discount = parseFloat(ds);
	 		}
	 		net_price -= item_discount;
	 		var pr_tax = item.row.tax_rate, pr_tax_val = 0;
 		    if (pr_tax !== null && pr_tax != 0) {
 		        $.each(tax_rates, function () {
 		        	if(this.id == pr_tax){
 			        	if (this.type == 1) {

 			        		if (positems[item_id].row.tax_method == 0) {
 			        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
 			        			pr_tax_rate = formatDecimal(this.rate) + '%';
 			        			net_price -= pr_tax_val;
 			        		} else {
 			        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
 			        			pr_tax_rate = formatDecimal(this.rate) + '%';
 			        		}

 			        	} else if (this.type == 2) {

 			        		pr_tax_val = parseFloat(this.rate);
 			        		pr_tax_rate = this.rate;

 			        	}
 			        }
 			    });
 		    }
		}
		if (site.settings.product_serial !== 0) {
			$('#pserial').val(row.children().children('.rserial').val());
		}
		var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
		if(item.options !== false) {
			var o = 1;
			opt = $("<select id=\"poption\" name=\"poption\" class=\"form-control select\" />");
			$.each(item.options, function () {
				if(o == 1) {
					if(product_option == '') { product_variant = this.id; } else { product_variant = product_option; }
				}
				$("<option />", {value: this.id, text: this.name}).appendTo(opt);
				o++;
			});
		}

		$('#poptions-div').html(opt);
		$('select.select').select2({minimumResultsForSearch: 6});
		$('#pquantity').val(qty);
		$('#old_qty').val(qty);
		$('#pprice').val(unit_price);
		$('#punit_price').val(formatDecimal(parseFloat(unit_price)+parseFloat(pr_tax_val)));
		$('#poption').select2('val', item.row.option);
		$('#old_price').val(unit_price);
		$('#row_id').val(row_id);
		$('#item_id').val(item_id);
		$('#pserial').val(row.children().children('.rserial').val());
		$('#pdiscount').val(discount);
		$('#net_price').text(formatMoney(net_price));
	    $('#pro_tax').text(formatMoney(pr_tax_val));
		$('#prModal').appendTo("body").modal('show');

	});

	$('#prModal').on('shown.bs.modal', function (e) {
		if($('#poption').select2('val') != '') {
			$('#poption').select2('val', product_variant);
			product_variant = 0;
		}
	});

	$(document).on('change', '#pprice, #ptax, #pdiscount', function () {
	    var row = $('#' + $('#row_id').val());
	    var item_id = row.attr('data-item-id');
	    var unit_price = parseFloat($('#pprice').val());
	    var item = positems[item_id];
	    var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
	    if (ds.indexOf("%") !== -1) {
	        var pds = ds.split("%");
	        if (!isNaN(pds[0])) {
	            item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
	        } else {
	            item_discount = parseFloat(ds);
	        }
	    } else {
	        item_discount = parseFloat(ds);
	    }
	    unit_price -= item_discount;
	    var pr_tax = $('#ptax').val(), item_tax_method = item.row.tax_method;
	    var pr_tax_val = 0, pr_tax_rate = 0;
	    if (pr_tax !== null && pr_tax != 0) {
	        $.each(tax_rates, function () {
	        	if(this.id == pr_tax){
		        	if (this.type == 1) {

		        		if (item_tax_method == 0) {
		        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
		        			pr_tax_rate = formatDecimal(this.rate) + '%';
		        			unit_price -= pr_tax_val;
		        		} else {
		        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
		        			pr_tax_rate = formatDecimal(this.rate) + '%';
		        		}

		        	} else if (this.type == 2) {

		        		pr_tax_val = parseFloat(this.rate);
		        		pr_tax_rate = this.rate;

		        	}
		        }
		    });
	    }

	    $('#net_price').text(formatMoney(unit_price));
	    $('#pro_tax').text(formatMoney(pr_tax_val));
	});

	/* -----------------------
	 * Edit Row Method
	 ----------------------- */
	 $(document).on('click', '#editItem', function () {
		var row = $('#' + $('#row_id').val());
		var item_id = row.attr('data-item-id'), new_pr_tax = $('#ptax').val(), new_pr_tax_rate = {};
		if (new_pr_tax) {
			$.each(tax_rates, function () {
				if (this.id == new_pr_tax) {
					new_pr_tax_rate = this;
				}
			});
		} else {
			new_pr_tax_rate = false;
		}
		var price = parseFloat($('#pprice').val());
		if (site.settings.product_discount == 1 && $('#pdiscount').val()) {
			if(!is_valid_discount($('#pdiscount').val()) || $('#pdiscount').val() > price) {
				bootbox.alert(lang.unexpected_value);
				return false;
			}
		}
		positems[item_id].row.qty = parseFloat($('#pquantity').val()),
		positems[item_id].row.real_unit_price = price,
		positems[item_id].row.tax_rate = new_pr_tax,
	 	positems[item_id].tax_rate = new_pr_tax_rate,
		positems[item_id].row.discount = $('#pdiscount').val() ? $('#pdiscount').val() : '',
		positems[item_id].row.option = $('#poption').val() ? $('#poption').val() : '',
		positems[item_id].row.serial = $('#pserial').val();
		localStorage.setItem('positems', JSON.stringify(positems));
		$('#prModal').modal('hide');

		loadItems();
		return;
	});

	/* -----------------------
	 * Product option change
	 ----------------------- */
	 $(document).on('change', '#poption', function () {
	 	var row = $('#' + $('#row_id').val()), opt = $(this).val();
	 	var item_id = row.attr('data-item-id');
	 	var item = positems[item_id];
	 	if(item.options !== false) {
	 		$.each(item.options, function () {
	 			if(this.id == opt && this.price != 0) {
	 				$('#pprice').val(this.price);
	 			}
	 		});
	 	}
	 });

	 /* ------------------------------
	 * Sell Gift Card modal
	 ------------------------------- */
	 $(document).on('click', '#sellGiftCard', function (e) {
	 	if (count == 1) {
	 		positems = {};
	 		if ($('#poswarehouse').val() && $('#poscustomer').val()) {
	 			$('#poscustomer').select2("readonly", true);
	 			$('#poswarehouse').select2("readonly", true);
	 		} else {
	 			bootbox.alert(lang.select_above);
	 			item = null;
	 			return false;
	 		}
	 	}
	 	$('#gcModal').appendTo("body").modal('show');
	 	return false;
	 });

	 $('#gccustomer').select2({
	 	minimumInputLength: 1,
	 	ajax: {
	 		url: site.base_url+"customers/suggestions",
	 		dataType: 'json',
	 		quietMillis: 15,
	 		data: function (term, page) {
	 			return {
	 				term: term,
	 				limit: 10
	 			};
	 		},
	 		results: function (data, page) {
	 			if(data.results != null) {
	 				return { results: data.results };
	 			} else {
	 				return { results: [{id: '', text: 'No Match Found'}]};
	 			}
	 		}
	 	}
	 });

	 $('#genNo').click(function(){
	 	var no = generateCardNo();
	 	$(this).parent().parent('.input-group').children('input').val(no);
	 	return false;
	 });

	 $(document).on('click', '#addGiftCard', function (e) {
	 	var mid = (new Date).getTime(),
	 	gccode = $('#gccard_no').val(),
	 	gcname = $('#gcname').val(),
	 	gcvalue = $('#gcvalue').val(),
	 	gccustomer = $('#gccustomer').val(),
	 	gcexpiry = $('#gcexpiry').val() ? $('#gcexpiry').val() : '',
	 	gcprice = parseFloat($('#gcprice').val());
	 	if(gccode == '' || gcvalue == '' || gcprice == '' || gcvalue == 0 || gcprice == 0) {
	 		$('#gcerror').text('Please fill the required fields');
	 		$('.gcerror-con').show();
	 		return false;
	 	}

	 	var gc_data = new Array();
	 	gc_data[0] = gccode;
	 	gc_data[1] = gcvalue;
	 	gc_data[2] = gccustomer;
	 	gc_data[3] = gcexpiry;
		//if (typeof positems === "undefined") {
		//    var positems = {};
		//}

		$.ajax({
			type: 'get',
			url: site.base_url+'sales/sell_gift_card',
			dataType: "json",
			data: { gcdata: gc_data },
			success: function (data) {
				if(data.result === 'success') {
					positems[mid] = {"id": mid, "item_id": mid, "label": gcname + ' (' + gccode + ')', "row": {"id": mid, "code": gccode, "name": gcname, "quantity": 1, "price": gcprice, "tax_rate": 0, "qty": 1, "type": "manual", "discount": "0", "serial": "", "option":""}, "tax_rate": false, "options":false};
					localStorage.setItem('positems', JSON.stringify(positems));
					loadItems();
					$('#gcModal').modal('hide');
					$('#gccard_no').val('');
					$('#gcvalue').val('');
					$('#gcexpiry').val('');
					$('#gcprice').val('');
				} else {
					$('#gcerror').text(data.message);
					$('.gcerror-con').show();
				}
			}
		});
		return false;
	});

	/* ------------------------------
	 * Show manual item addition modal
	 ------------------------------- */
	 $(document).on('click', '#addManually', function (e) {
		if (count == 1) {
			positems = {};
			if ($('#poswarehouse').val() && $('#poscustomer').val()) {
				$('#poscustomer').select2("readonly", true);
				$('#poswarehouse').select2("readonly", true);
			} else {
				bootbox.alert(lang.select_above);
				item = null;
				return false;
			}
		}
		$('#mnet_price').text('0.00');
		$('#mpro_tax').text('0.00');
		$('#mModal').appendTo("body").modal('show');
		return false;
	});

	 $(document).on('click', '#addItemManually', function (e) {
		var mid = (new Date).getTime(),
		mcode = $('#mcode').val(),
		mname = $('#mname').val(),
		mper_type = $('#mper_type').val(),
		mhsn_sac = $('#mhsn_sac').val(),
		mtax = parseInt($('#mtax').val()),
		mqty = parseFloat($('#mquantity').val()),
		mdiscount = $('#mdiscount').val() ? $('#mdiscount').val() : '0',
		unit_price = parseFloat($('#mprice').val()),
		mtax_rate = {};
		$.each(tax_rates, function () {
			if (this.id == mtax) {
				mtax_rate = this;
			}
		});

		positems[mid] = {"id": mid, "item_id": mid, "label": mname + ' (' + mcode + ')', "row": {"id": mid, "code": mcode, "name": mname, "hsn_sac": mhsn_sac,"quantity": mqty,"per_type": mper_type, "price": unit_price, "unit_price": unit_price, "real_unit_price": unit_price, "tax_rate": mtax, "tax_method": 0, "qty": mqty, "type": "manual", "discount": mdiscount, "serial": "", "option":""}, "tax_rate": mtax_rate, "options":false};
		localStorage.setItem('positems', JSON.stringify(positems));
		loadItems();
		$('#mModal').modal('hide');
		$('#mcode').val('');
		$('#mname').val('');
		$('#mtax').val('');
		$('#mhsn_sac').val('');
		$('#mper_type').val('');
		$('#mquantity').val('');
		$('#mdiscount').val('');
		$('#mprice').val('');
		return false;
	});

	$(document).on('change', '#mprice, #mtax, #mdiscount', function () {
	    var unit_price = parseFloat($('#mprice').val());
	    var ds = $('#mdiscount').val() ? $('#mdiscount').val() : '0';
	    if (ds.indexOf("%") !== -1) {
	        var pds = ds.split("%");
	        if (!isNaN(pds[0])) {
	            item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
	        } else {
	            item_discount = parseFloat(ds);
	        }
	    } else {
	        item_discount = parseFloat(ds);
	    }
	    unit_price -= item_discount;
	    var pr_tax = $('#mtax').val(), item_tax_method = 0;
	    var pr_tax_val = 0, pr_tax_rate = 0;
	    if (pr_tax !== null && pr_tax != 0) {
	        $.each(tax_rates, function () {
	        	if(this.id == pr_tax){
		        	if (this.type == 1) {

		        		if (item_tax_method == 0) {
		        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
		        			pr_tax_rate = formatDecimal(this.rate) + '%';
		        			unit_price -= pr_tax_val;
		        		} else {
		        			pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
		        			pr_tax_rate = formatDecimal(this.rate) + '%';
		        		}

		        	} else if (this.type == 2) {

		        		pr_tax_val = parseFloat(this.rate);
		        		pr_tax_rate = this.rate;

		        	}
		        }
		    });
	    }

	    $('#mnet_price').text(formatMoney(unit_price));
	    $('#mpro_tax').text(formatMoney(pr_tax_val));
	});

	/* --------------------------
	 * Edit Row Quantity Method
	 -------------------------- */

	 $(document).on("change", '.rquantity', function () {
	 	var row = $(this).closest('tr');
	 	if (!is_numeric($(this).val()) || $(this).val() == 0) {
	 		loadItems();
	 		bootbox.alert(lang.unexpected_value);
	 		return false;
	 	}
	 	var new_qty = parseFloat($(this).val()),
	 	item_id = row.attr('data-item-id');
	 	positems[item_id].row.qty = new_qty;
	 	localStorage.setItem('positems', JSON.stringify(positems));
	 	loadItems();
	 });

	 

	// var old_row_staff;  
 //     $(document).on("focus", '.staff_no', function () {
     	
 //        old_row_staff = $(this).val();
 //    }).on("change", '.staff_no', function () {
 //        var row = $(this).closest('tr');
        
 //        var new_staff = $(this).val();
 //        var new_staff_name = $(this).find('option:selected').text();

 //        var item_id = row.attr('data-item-id');
 //        var id = $(this).attr('id');       
 //        var sname = $(this).attr('class');       
 //        staff_no = new_staff;
 //        staff_name = new_staff_name;
 //        localStorage.setItem(id, staff_no);
 //        localStorage.setItem(sname, staff_name);
        
 //        loadItems();
 //    });
    



// end ready function
});

/* -----------------------
 * Load all items
 ----------------------- */

//localStorage.clear();
function loadItems() {

	if (localStorage.getItem('positems')) {
		total = 0;
		member_total = 0;
		total_final = 0;
		invoice_tax_final = 0;
		product_tax_final = 0;
		total = 0;
		member_total = 0;
		total_without_gst = 0;
		member_total_without_gst = 0;
		count = 1;
		an = 1;
		product_tax = 0;
		product_tax_mem = 0;
		invoice_tax = 0;
		invoice_tax_mem = 0;
		product_discount = 0;
		order_discount = 0;
		coupon_discount = 0;
		total_discount = 0;
		group = 0;
		

		$("#posTable tbody").empty();
		if(java_applet == 1) {
			order_data = "";
			bill_data = "";
			bill_data += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
			bill_data += site.settings.site_name + "\n\n";
			order_data = bill_data;
			bill_data += "Bill" + "\n";
			order_data += "Order" + "\n";
			bill_data += $('#select2-chosen-1').text() + "\n\n";
			bill_data += " \x1B\x45\x0A\r\n ";
			order_data += $('#select2-chosen-1').text() + "\n\n";
			order_data += " \x1B\x45\x0A\r\n ";
			bill_data += "\x1B\x61\x30";
			order_data += "\x1B\x61\x30";
		} else {
			$("#order_span").empty(); $("#bill_span").empty();
			var pos_head1 = '<span style="text-align:center;"><h3>'+site.settings.site_name+'</h3><h4>'
			var pos_head2 = '</h4><h5>'+$('#select2-chosen-1').text()+'<br>'+Date()+'</h5></span>';
			$("#order_span").prepend(pos_head1+' Order '+pos_head2);
			$("#bill_span").prepend(pos_head1+' Bill '+pos_head2);
			$("#order-table").empty(); $("#bill-table").empty();
		}
		positems = JSON.parse(localStorage.getItem('positems'));

		$.each(positems, function () {

			var item = this;
			var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
			positems[item_id] = item;
			var product_id = item.row.id, item_type = item.row.type,sub_name = item.row.sub_name, combo_items = item.combo_items, item_price = item.row.price,item_member_price = item.row.member_price,item_per_type = item.row.per_type,item_hsn_sac = item.row.hsn_sac, item_qty = item.row.qty, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");

			var unit_price = item.row.real_unit_price;
			var unit_mem_price = item.row.member_price;
			var group = item.group;
			
			console.log(item_member_price);
			var ds = item_ds ? item_ds : '0';
			
			if (ds.indexOf("%") !== -1) {
				var pds = ds.split("%");
				if (!isNaN(pds[0])) {
					item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(pds[0])) / 100));
				} else {
					item_discount = formatDecimal(ds);
				}
			} else {
				 item_discount = parseFloat(ds);
			}
			product_discount += parseFloat(item_discount * item_qty);

			unit_price = formatDecimal(unit_price-item_discount);
			unit_mem_price = formatDecimal(unit_mem_price-item_discount);
			
			var pr_tax = item.tax_rate;
			var pr_tax_val = 0, pr_tax_rate = 0, pr_tax_val_mem = 0;
			if (site.settings.tax1 == 1) {
				if (pr_tax !== false) {
					if (pr_tax.type == 1) {

						if (item_tax_method == '0') {
							pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)));
							pr_tax_val_mem = formatDecimal(((unit_mem_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)));
							pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
						} else {
							pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100);
							pr_tax_val_mem = formatDecimal(((unit_mem_price) * parseFloat(pr_tax.rate)) / 100);
							pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
						}

					} else if (pr_tax.type == 2) {

						pr_tax_val = parseFloat(pr_tax.rate);
						pr_tax_val_mem = parseFloat(pr_tax.rate);
						pr_tax_rate = pr_tax.rate;

					}
					product_tax += pr_tax_val * item_qty;
					product_tax_mem += pr_tax_val_mem * item_qty;
					
				}
			}
			item_price = item_tax_method == 0 ? formatDecimal(unit_price-pr_tax_val) : formatDecimal(unit_price);
			item_member_price = item_tax_method == 0 ? formatDecimal(unit_mem_price-pr_tax_val_mem) : formatDecimal(unit_mem_price);
			
			unit_price = formatDecimal(unit_price+item_discount);
			unit_mem_price = formatDecimal(unit_mem_price+item_discount);
			var sel_opt = '';
			$.each(item.options, function () {  
				if(this.id == item_option) {
					sel_opt = this.name;
				}
			});
  
			var row_no = (new Date).getTime();
			var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
			tr_html = '<td class="proname_' + item_id + '"></td><td><input name="item_id[]" type="hidden" class="ritem_id" value="' + item_id + '"><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '"><input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '"><input name="product_name[]" type="hidden" class="rname" value="' + item_name + '"><input name="hsn_sac[]" type="hidden" class="rhsn_sac" value="' + item_hsn_sac + '"><input name="per_type[]" type="hidden" class="rper_type" value="' + item_per_type + '"><input name="product_option[]" type="hidden" class="roption" value="' + item_option + '"><span class="sname" id="name_' + row_no + '">' + item_name + ' (' + item_code + ')'+' (' + sub_name + ')'+(sel_opt != '' ? ' ('+sel_opt+')' : '')+'</span><i class="pull-right fa fa-edit tip pointer edit" id="' + row_no + '" data-item="' + item_id + '" title="Edit" style="cursor:pointer;"></i></td>';
			tr_html += '<td class="text-right">';
			if (site.settings.product_serial == 1) {
				tr_html += '<input class="form-control input-sm rserial" name="serial[]" type="hidden" id="serial_' + row_no + '" value="'+item_serial+'">';
			}
			if (site.settings.product_discount == 1) {
				tr_html += '<input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '">';
			}
			if (site.settings.tax1 == 1) {
				if (group == 5) {
				tr_html += '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><input type="hidden" class="sproduct_tax" id="sproduct_tax_' + row_no + '" value="' + formatMoney(pr_tax_val_mem * item_qty) + '">';
				}else{
				tr_html += '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><input type="hidden" class="sproduct_tax" id="sproduct_tax_' + row_no + '" value="' + formatMoney(pr_tax_val * item_qty) + '">';
				}

			}
			if (group == 5) {
			tr_html += '<input class="rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + item_member_price + '"><input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_mem_price + '"><input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.member_price + '"><span class="text-right sprice" id="sprice_' + row_no + '"><font style="color:red;">' +formatMoney(parseFloat(item_member_price))+ '</font><br>' + formatMoney(parseFloat(item_price)) + '</span></td>';
			}else
			{
			tr_html += '<input class="rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + item_price + '"><input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_price + '"><input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.real_unit_price + '"><span class="text-right sprice" id="sprice_' + row_no + '"><font style="color:red;">' +formatMoney(parseFloat(item_member_price))+ '</font><br>' + formatMoney(parseFloat(item_price)) + '</span></td>';
			}

			
			tr_html += '<td><input class="form-control kb-pad text-center rquantity quant_'+ item_id +'" name="quantity[]" type="text" value="' + formatDecimal(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
			if (site.settings.product_discount == 1) {
				tr_html += '<td class="text-right"><input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '"><span class="text-right sdiscount text-danger" id="sdiscount_' + row_no + '">' + formatMoney(0 - (item_discount * item_qty)) + '</span></td>';
			}
			
			if (group == 5) {
			tr_html += '<td class="text-right"><span class="text-right sptax" id="sptax_' + row_no + '">('+ parseFloat(pr_tax.rate) + '%) ' + formatMoney(parseFloat(pr_tax_val_mem) * parseFloat(item_qty)) + '</span></td>';
			}else{
			tr_html += '<td class="text-right"><span class="text-right sptax" id="sptax_' + row_no + '">('+ parseFloat(pr_tax.rate) + '%) ' + formatMoney(parseFloat(pr_tax_val) * parseFloat(item_qty)) + '</span></td>';
			}

			tr_html += '<td class="text-right"><span class="text-right ssubtotalof1" style="color:red;" id="subtotalof_' + row_no + '">'+formatMoney((parseFloat(item_member_price) + parseFloat(pr_tax_val_mem)) * parseFloat(item_qty))+'</span></td>';
			tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</span></td>';
			tr_html += '<td class="text-center"><i class="fa fa-times tip pointer posdel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
			newTr.html(tr_html);
			newTr.prependTo("#posTable");
			// total += formatDecimal(item_price * item_qty);
			total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)));
			
			member_total += formatDecimal(((parseFloat(item_member_price) + parseFloat(pr_tax_val_mem)) * parseFloat(item_qty)));
				
			total_without_gst += formatDecimal(((parseFloat(item_price)) * parseFloat(item_qty)));
			
			member_total_without_gst += formatDecimal(((parseFloat(item_member_price)) * parseFloat(item_qty)));
			
			count += parseFloat(item_qty);
			an++;
			if (item_type == 'standard' && item.options !== false) {
				$.each(item.options, function () {
					if(this.id == item_option && item_qty > this.quantity) {
						$('#row_' + row_no).addClass('danger');
					}
				});
			} else if(item_type == 'standard' && item_qty > item_aqty) {
				$('#row_' + row_no).addClass('danger');
			} else if (item_type == 'combo') {
				if(combo_items === false) {
					$('#row_' + row_no).addClass('danger');
				} else {
					$.each(combo_items, function(){
						if(parseFloat(this.quantity) < (parseFloat(this.qty)*item_qty)) {
							$('#row_' + row_no).addClass('danger');
						}
					});
				}
			}
			if(java_applet == 1) {
				bill_data += "#"+(an-1)+" "+ item_name + " (" + item_code + ")" + "\n";
				bill_data += printLine(item_qty + " x " + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val))+": "+ formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)))) + "\n";
				order_data += printLine("#"+(an-1)+" "+ item_name + " (" + item_code + "):"+ formatDecimal(item_qty)) + "\n";
			} else {
				var bprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td colspan="2">#'+(an-1)+' '+ item_name + ' (' + item_code + ')</td></tr>';
				bprTr += '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>(' + formatDecimal(item_qty) + ' x ' + (item_discount != 0 ? '<del>'+formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val) + item_discount)+'</del>' : '') + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val))+ ')</td><td style="text-align:right;">'+ formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) +'</td></tr>';
				var oprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>#'+(an-1)+' ' + item_name + ' (' + item_code + ')</td><td>' + formatDecimal(item_qty) +'</td></tr>';
				$("#order-table").append(oprTr);
				$("#bill-table").append(bprTr);
			}

				$.ajax({
					type: 'get',
					url: site.base_url+'pos/get_staff',
					dataType: "json",
						success: function (data) {
							var option_data = data.option;	
							$('.staff_no').html(option_data);  


				    	}
				});
			
			    var row_id = $('.rquantity').attr('data-id');
                var serialdata_range = $('.quant_' + item_id).val();
                var st = 1;
                var staff_inputs ='';
                	
                for(i = 0; i < serialdata_range ; i++)
                {
                    var id = "staff_"+ i +"_" + item_id;
                    var sname = "staff-class staff_no select2-input staffclass_"+ i +"_" + item_id;
                    var staff_value =localStorage.getItem(id);
                    var staff_name =localStorage.getItem(sname);
                    if(staff_value != null)
                    {
                        $("#staff_"+i+"_"+item_id).append('<option value='+staff_value+' selected="selected">'+staff_name+'</option>')
                    }
                    
					staff_inputs +='<select name="staff_'+item_code+'_'+item_id+'[]" required="required" placeholder="Staff '+ st +'"  class="staff-class staff_no select2-input staffclass_'+ i +'_' + item_id +'" data-id="' + row_no + '" data-item-id="' + item_id + '" id="staff_'+ i +'_' + item_id +'"></select>';
                	
                    st++;
                }
                $('.proname_'+item_id).append('<div>'+staff_inputs+'</div>');  
                

         
		});
			
	 	
		// Order level discount calculations
		if (posdiscount = localStorage.getItem('posdiscount')) {
			var ds = posdiscount;
			if (ds.indexOf("%") !== -1) {
				var pds = ds.split("%"); 
				if (!isNaN(pds[0])) {
					if(group == 5){
						order_discount = formatDecimal(((member_total) * parseFloat(pds[0])) / 100);
					}else
					{
						order_discount = formatDecimal(((total) * parseFloat(pds[0])) / 100);
					}
				} else {
					order_discount = formatDecimal(ds);
				}
			} else {
				order_discount = formatDecimal(ds);
			}
			console.log('order_discount', order_discount)
			//total_discount += parseFloat(order_discount);
		}

		if (poscoupon = localStorage.getItem('poscoupon')) {
			var cs = poscoupon;
			if (cs.indexOf("%") !== -1) {
				var pcs = cs.split("%");
				if (!isNaN(pcs[0])) {
					if(group == 5){
						coupon_discount = formatDecimal(((member_total) * parseFloat(pcs[0])) / 100);
					}else
					{
						coupon_discount = formatDecimal(((total) * parseFloat(pcs[0])) / 100);
					}
				} else {
					coupon_discount = formatDecimal(cs);
				}
				
			} else {
				coupon_discount = formatDecimal(cs);
			}

			//total_discount += parseFloat(order_discount);
		}

		// Order level tax calculations 
		if (site.settings.tax2 != 0) {
			if (postax2 = localStorage.getItem('postax2')) {
				$.each(tax_rates, function () {
					if (this.id == postax2) {
						if (this.type == 2) {
							invoice_tax = formatDecimal(this.rate);
							invoice_tax_mem = formatDecimal(this.rate);
						}
						if (this.type == 1) {
							invoice_tax = formatDecimal(((total + product_tax - order_discount - coupon_discount) * this.rate) / 100);
							invoice_tax_mem = formatDecimal(((member_total + product_tax_mem - order_discount - coupon_discount) * this.rate) / 100);
						}
					}
				});
			}
		}

		total = formatDecimal(total);
		member_total = formatDecimal(member_total);
		total_without_gst = formatDecimal(total_without_gst);
		member_total_without_gst = formatDecimal(member_total_without_gst);
		
		total_discount = formatDecimal(order_discount + product_discount + coupon_discount);

		// Totals calculations after item addition
		var group = localStorage.getItem('group');
		if(group == 5){
			var gtotal = parseFloat(((member_total + invoice_tax_mem) - order_discount - coupon_discount) + shipping);
			var non_gtotal = parseFloat(((total + invoice_tax) - order_discount - coupon_discount) + shipping);
			product_tax_final = formatDecimal(product_tax_mem);
			invoice_tax_final = invoice_tax_mem;	
			total_final = member_total;
			total_without_gst_final = member_total_without_gst;
		
		}else
		{
			var gtotal = parseFloat(((total + invoice_tax) - order_discount - coupon_discount) + shipping);
			var non_gtotal = parseFloat(((total + invoice_tax) - order_discount - order_discount) + shipping);
			product_tax_final = formatDecimal(product_tax);
			invoice_tax_final = invoice_tax;
			
			total_final = total;

			total_without_gst_final = total_without_gst;
				
		}
		$('#total').html('<span style="color:red">'+formatMoney(member_total_without_gst)+'</span> | '+formatMoney(total_without_gst));
		
		$('#totaltext').val(parseFloat(total_final));
		
		$('#totalnontext').val(parseFloat(total_without_gst));
		
		$('#titems').text((an - 1) + ' (' + (parseFloat(count) - 1) + ')');
		
		$('#total_items').val((parseFloat(count) - 1));
		console.log('order_discount1', order_discount);
		$('#tds').text('('+formatMoney(product_discount)+') '+formatMoney(order_discount + coupon_discount));
		
		//$('#tds1').text(formatMoney(coupon_discount));
			
		$('#tax_total').text(formatMoney(product_tax_final));
		
		$('#taxtext').val(parseFloat(product_tax_final));
		
		if (site.settings.tax2 != 0) {
			$('#ttax2').text(formatMoney(invoice_tax_final));
		}
		$('#gtotal').text(formatMoney(gtotal));
		$('#non_gtotal').val(parseFloat(non_gtotal));
		
		$('#gtotaltext').val(parseFloat(gtotal));
		
		if(java_applet == 1) {
			bill_data += "\n"+ printLine(lang_total+': '+ formatMoney(total)) +"\n";
			bill_data += printLine(lang_items+': '+ (an - 1) + ' (' + (parseFloat(count) - 1) + ')') +"\n";
			if(total_discount > 0) {
				bill_data += printLine(lang_discount+': ('+formatMoney(product_discount)+') '+formatMoney(order_discount + coupon_discount)) +"\n";
			}
			if (site.settings.tax2 != 0 && invoice_tax != 0) {
				bill_data += printLine(lang_tax2+': '+ formatMoney(invoice_tax)) +"\n";
			}
			bill_data += printLine(lang_total_payable+': '+ formatMoney(gtotal)) +"\n";
		} else {
			var bill_totals = '';
			bill_totals += '<tr><td>'+lang_total+'</td><td style="text-align:right;">'+formatMoney(total_final)+'</td></tr>';
			bill_totals += '<tr><td>'+lang_items+'</td><td style="text-align:right;">'+(an - 1) + ' (' + (parseFloat(count) - 1) + ')</td></tr>';
			if(order_discount > 0) {
				bill_totals += '<tr><td>'+lang_discount+'</td><td style="text-align:right;">'+formatMoney(order_discount)+'</td></tr>';
			}
			if(coupon_discount > 0) {
				bill_totals += '<tr><td>'+lang_discount+'</td><td style="text-align:right;">'+formatMoney(coupon_discount)+'</td></tr>';
			}
			if (site.settings.tax2 != 0 && invoice_tax != 0) {
				bill_totals += '<tr><td>'+lang_tax2+'</td><td style="text-align:right;">'+formatMoney(invoice_tax_final)+'</td></tr>';
			}
			bill_totals += '<tr><td>'+lang_total_payable+'</td><td style="text-align:right;">'+formatMoney(gtotal)+'</td></tr>';
			$('#bill-total-table').empty();
			$('#bill-total-table').append(bill_totals);
		}
		if(count > 1) {
			$('#poscustomer').select2("readonly", true);
			$('#poswarehouse').select2("readonly", true);
		} else {
			$('#poscustomer').select2("readonly", false);
			$('#poswarehouse').select2("readonly", false);
		}
		if (KB) { display_keyboards(); }
		//audio_success.play();
		//$('#posTable > tbody > tr:first').children().children('.rquantity').focus(); // to auto focus quantity input of top item
		$('#add_item').focus();
	}
}

function printLine(str) {
	var size = pos_settings.char_per_line;
	var len = str.length;
	var res = str.split(":");
	var newd = res[0];
	for(i=1; i<(size-len); i++) {
		newd += " ";
	}
	newd += res[1];
	return newd;
}

/* -----------------------------
 * Add Purchase Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */

 function add_invoice_item(item) {

 	if (count == 1) {
 		positems = {};
 		if ($('#poswarehouse').val() && $('#poscustomer').val()) {
 			$('#poscustomer').select2("readonly", true);
 			$('#poswarehouse').select2("readonly", true);
 		} else {
 			bootbox.alert(lang.select_above);
 			item = null;
 			return;
 		}
 	}
 	if (item == null) {
 		return;
 	}

 	var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
 	if (positems[item_id]) {
 		positems[item_id].row.qty = parseFloat(positems[item_id].row.qty) + 1;
 	} else {
 		positems[item_id] = item;
 	}
 	var group = item.group;
 	localStorage.setItem('group', group);
 		// if (group == 5) {
			// var ds = '10%';
		 // 	var ds_id = '5';
		 // 	var ds_name = 'Member Discount';
		 // 		$('#posdiscount').val(ds);
		 // 		$('#posdiscount_id').val(ds_id);
		 // 		$('#posdiscount_name').text(ds_name);
		 // 		localStorage.removeItem('posdiscount');
		 // 		localStorage.setItem('posdiscount', ds);
		 // 		localStorage.removeItem('posdiscount_id');
		 // 		localStorage.setItem('posdiscount_id', ds_id);
		 // 		localStorage.removeItem('posdiscount_name');
			// 	localStorage.setItem('posdiscount_name', 'Member Discount');
				 	
	 	// }else{
	 		var ds = '';
		 	var ds_id = '';
		 	var ds_name = '';
	 			$('#posdiscount').val(ds);
		 		$('#posdiscount_id').val(ds_id);
		 		$('#posdiscount_name').text(ds_name);
		 		localStorage.removeItem('posdiscount');
		 		localStorage.setItem('posdiscount', ds);
		 		localStorage.removeItem('posdiscount_id');
		 		localStorage.setItem('posdiscount_id', ds_id);
		 		localStorage.removeItem('posdiscount_name');
				localStorage.setItem('posdiscount_name', '');

			var cop = '';
		 	var cop_id = '';
		 	var cop_name = '';
	 			$('#poscoupon').val(cop);
		 		$('#poscoupon_id').val(cop_id);
		 		$('#poscoupon_name').text(cop_name);
		 		localStorage.removeItem('poscoupon');
		 		localStorage.setItem('poscoupon', cop);
		 		localStorage.removeItem('poscoupon_id');
		 		localStorage.setItem('poscoupon_id', cop_id);
		 		localStorage.removeItem('poscoupon_name');
				localStorage.setItem('poscoupon_name', '');	
			
	 	// }



 	localStorage.setItem('positems', JSON.stringify(positems));
 	loadItems();
 	return true;
 }


 if (typeof (Storage) === "undefined") {
 	$(window).bind('beforeunload', function (e) {
 		if (count > 1) {
 			var message = "You will loss data!";
 			return message;
 		}
 	});
 }

 function display_keyboards() {

 	$('.kb-text').keyboard({
 		autoAccept: true,
 		alwaysOpen: false,
 		openOn: 'focus',
 		usePreview: false,
 		layout: 'custom',
		//layout: 'qwerty',
		display: {
			'bksp': "\u2190",
			'accept': 'return',
			'default': 'ABC',
			'meta1': '123',
			'meta2': '#+='
		},
		customLayout: {
			'default': [
			'q w e r t y u i o p {bksp}',
			'a s d f g h j k l {enter}',
			'{s} z x c v b n m , . {s}',
			'{meta1} {space} {cancel} {accept}'
			],
			'shift': [
			'Q W E R T Y U I O P {bksp}',
			'A S D F G H J K L {enter}',
			'{s} Z X C V B N M / ? {s}',
			'{meta1} {space} {meta1} {accept}'
			],
			'meta1': [
			'1 2 3 4 5 6 7 8 9 0 {bksp}',
			'- / : ; ( ) \u20ac & @ {enter}',
			'{meta2} . , ? ! \' " {meta2}',
			'{default} {space} {default} {accept}'
			],
			'meta2': [
			'[ ] { } # % ^ * + = {bksp}',
			'_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
			'{meta1} ~ . , ? ! \' " {meta1}',
			'{default} {space} {default} {accept}'
			]}
		});
 	$('.kb-pad').keyboard({
 		restrictInput: true,
 		preventPaste: true,
 		autoAccept: true,
 		alwaysOpen: false,
 		openOn: 'click',
 		usePreview: false,
 		layout: 'costom',
 		display: {
 			'b': '\u2190:Backspace',
 		},
 		customLayout: {
 			'default': [
 			'1 2 3 {b}',
 			'4 5 6 . {clear}',
 			'7 8 9 0 %',
 			'{accept} {cancel}'
 			]
 		}
 	});

 }

 $('body').bind('keypress', function(e) {
 	if (e.keyCode == 13) {
 		e.preventDefault();
 		return false;
 	}
 });

/*$(window).bind('beforeunload', function(e) {
	if(count > 1){
	var msg = 'You will loss the sale data.';
		(e || window.event).returnValue = msg;
		return msg;
	}
});
*/
if(site.settings.auto_detect_barcode == 1) {
	$(document).ready(function() {
		var pressed = false;
		var chars = [];
		$(window).keypress(function(e) {
			if(e.key == '%') { pressed = true; }
			chars.push(String.fromCharCode(e.which));
			if (pressed == false) {
				setTimeout(function(){
					if (chars.length >= 8) {
						var barcode = chars.join("");
						$( "#add_item" ).focus().autocomplete( "search", barcode );
					}
					chars = [];
					pressed = false;
				},200);
			}
			pressed = true;
		});
	});
}
$(document).ready(function() {
	read_card();
});

function generateCardNo(x) {
	if(!x) { x = 16; }
	chars = "1234567890";
	no = "";
	for (var i=0; i<x; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		no += chars.substring(rnum,rnum+1);
	}
	return no;
}
function roundNumber(number, toref) {
	switch(toref) {
	    case 1:
	        var rn = formatDecimal(Math.round(number * 20)/20);
	        break;
	    case 2:
	        var rn = formatDecimal(Math.round(number * 2)/2);
	        break;
	    case 3:
	        var rn = formatDecimal(Math.round(number));
	        break;
	    case 4:
	        var rn = formatDecimal(Math.ceil(number));
	        break;
	    default:
	        var rn = number;
	}
	return rn;
}
function getNumber(x) {
	return accounting.unformat(x);
}
function formatQuantity(x) { return formatNumber(x, site.settings.decimals); }
function formatNumber(x, d) {
	if(!d) { d = site.settings.decimals; }
    if(site.settings.sac == 1) {
        return formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
}
function formatMoney(x, symbol) {
    if(!symbol) { symbol = ""; }
    if(site.settings.sac == 1) {
        return symbol+''+formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
}
function formatDecimal(x) {
	return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
}
function is_valid_discount(mixed_var) {
	return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}
function is_numeric(mixed_var) {
	var whitespace =
	" \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
	return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
		1)) && mixed_var !== '' && !isNaN(mixed_var);
}
function is_float(mixed_var) {
	return +mixed_var === mixed_var && (!isFinite(mixed_var) || !! (mixed_var % 1));
}
function currencyFormat(x) {
	if (x != null) {
		return formatMoney(x);
	} else {
		return '0';
	}
}
function formatSA (x) {
    x=x.toString();
    var afterPoint = '';
    if(x.indexOf('.') > 0)
       afterPoint = x.substring(x.indexOf('.'),x.length);
    x = Math.floor(x);
    x=x.toString();
    var lastThree = x.substring(x.length-3);
    var otherNumbers = x.substring(0,x.length-3);
    if(otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

    return res;
}

function read_card() {
	$('.swipe').keypress( function (e) {
		e.preventDefault();
		var payid = $(this).attr('id'),
		id = payid.substr(payid.length - 1);
		var TrackData = $(this).val();
		if (e.keyCode == 13) {
			e.preventDefault();

			var p = new SwipeParserObj(TrackData);

			if(p.hasTrack1)
			{
		// Populate form fields using track 1 data
		var CardType = null;
		var ccn1 = p.account.charAt(0);
		if(ccn1 == 4)
			CardType = 'Visa';
		else if(ccn1 == 5)
			CardType = 'MasterCard';
		else if(ccn1 == 3)
			CardType = 'Amex';
		else if(ccn1 == 6)
			CardType = 'Discover';
		else
			CardType = 'Visa';

		$('#pcc_no_'+id).val(p.account);
		$('#pcc_holder_'+id).val(p.account_name);
		$('#pcc_month_'+id).val(p.exp_month);
		$('#pcc_year_'+id).val(p.exp_year);
		$('#pcc_cvv2_'+id).val('');
		$('#pcc_type_'+id).val(CardType);

	}
	else
	{
		$('#pcc_no_'+id).val('');
		$('#pcc_holder_'+id).val('');
		$('#pcc_month_'+id).val('');
		$('#pcc_year_'+id).val('');
		$('#pcc_cvv2_'+id).val('');
		$('#pcc_type_'+id).val('');
	}

	$('#pcc_cvv2_'+id).focus();
}

}).blur(function (e) {
	$(this).val('');
}).focus( function (e) {
	$(this).val('');
});
}


$.extend($.keyboard.keyaction, {
	enter : function(base) {
		base.accept();
	}
});

$(document).ajaxStart(function(){
  $('#ajaxCall').show();
}).ajaxStop(function(){
  $('#ajaxCall').hide();
});

$(document).ready(function(){
	$('#myModal').on('hidden.bs.modal', function() {
		$(this).find('.modal-dialog').empty();
		$(this).removeData('bs.modal');
	});
	$('#myModal2').on('hidden.bs.modal', function () {
		$(this).find('.modal-dialog').empty();
		$(this).removeData('bs.modal');
		$('#myModal').css('zIndex', '1050');
		$('#myModal').css('overflow-y', 'scroll');
	});
	$('#myModal2').on('show.bs.modal', function () {
		$('#myModal').css('zIndex', '1040');
	});
	$('.modal').on('hidden.bs.modal', function() {
		$(this).removeData('bs.modal');
	});
	$('.modal').on('show.bs.modal', function () {
		$('#modal-loading').show();
		$('.blackbg').css('zIndex', '1041');
		$('.loader').css('zIndex', '1042');
	}).on('hide.bs.modal', function () {
		$('#modal-loading').hide();
		$('.blackbg').css('zIndex', '3');
		$('.loader').css('zIndex', '4');
	});
	$('#clearLS').click(function(event) {
        bootbox.confirm("Are you sure?", function(result) {
        if(result == true) {
            localStorage.clear();
            location.reload();
        }
        });
        return false;
    });
});

//$.ajaxSetup ({ cache: false, headers: { "cache-control": "no-cache" } });
if(pos_settings.focus_add_item != '') { shortcut.add(pos_settings.focus_add_item, function() { $("#add_item").focus(); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.add_manual_product != '') { shortcut.add(pos_settings.add_manual_product, function() { $("#addManually").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.customer_selection != '') { shortcut.add(pos_settings.customer_selection, function() { $("#customer").select2("open"); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.add_customer != '') { shortcut.add(pos_settings.add_customer, function() { $("#add-customer").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.toggle_category_slider != '') { shortcut.add(pos_settings.toggle_category_slider, function() { $("#open-category").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.toggle_subcategory_slider != '') { shortcut.add(pos_settings.toggle_subcategory_slider, function() { $("#open-subcategory").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.cancel_sale != '') { shortcut.add(pos_settings.cancel_sale, function() { $("#reset").click(); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.suspend_sale != '') { shortcut.add(pos_settings.suspend_sale, function() { $("#suspend").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.print_items_list != '') { shortcut.add(pos_settings.print_items_list, function() { $("#print_btn").click(); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.finalize_sale != '') { shortcut.add(pos_settings.finalize_sale, function() { $("#payment").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.today_sale != '') { shortcut.add(pos_settings.today_sale, function() { $("#today_sale").click(); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.open_hold_bills != '') { shortcut.add(pos_settings.open_hold_bills, function() { $("#opened_bills").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
if(pos_settings.close_register != '') { shortcut.add(pos_settings.close_register, function() { $("#close_register").click(); }, { 'type':'keydown', 'propagate':false, 'target':document} ); }
shortcut.add("ESC", function() { $("#cp").trigger('click'); }, { 'type':'keydown', 'propagate':false, 'target':document} );

$(document).ready(function(){ $('#add_item').focus(); });
