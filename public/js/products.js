
var AjaxLib = {
		getAjax: function( dataURL ) {
			return jQuery.ajax({
				cache: false,
				url: dataURL
			});	
		},
		getAjaxDataJson: function( dataURL, query ) {
			return jQuery.ajax({
				data: query,
				dataType: 'json',
				url: dataURL
			});	
		},
		delAjaxData: function( dataURL ) {
			return jQuery.ajax({
				dataType: "json",
				url: dataURL,					
				cache: false
			});
		},	
		postAjaxData: function( dataURL, formData) {		
			return jQuery.post(dataURL, formData, function (data) {
			}, 'json'); 
		},

		postAjaxUpload: function( dataURL, formData){
			return jQuery.post( {
					url:  dataURL,
					data: formData,
					processData: false,
					contentType: false,
					dataType: 'json'
				});
		}
		
	};	
	

$(document).ready(function() {
	var Products = {
		Save: function( frm ) {
			var formData = $( frm ).serialize();
        	var saving = AjaxLib.postAjaxData( config.SitePath + '/products', formData );

			saving.done(function(data){
				
				if($('#record_id').val() == ''){
					
					 var cnt = 0;
					 var today = new Date();
					 var datenow = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+today.getDate();
					var ids = $('tbody tr:last td a').attr('href');
					var recordid = 0;
					var indexid = 0;
					if( ids == "undefined" || ids == null){
						
					}else{
						//
						var arr = ids.split('/');

						recordid = parseInt(arr[0]) + 1;
						indexid = parseInt(arr[1]) + 1;
						

					}

					$('table').find('tbody:last').append('<tr id="t' + cnt + '">' +
                            '<td class="text-left prodname">' + $('#product_name').val() + '</td>' +
                            '<td class="text-right prodqty">' + $('#product_qty').val() + '</td>' +
                            '<td class="text-right prodprice">' + $('#product_price').val() + '</td>' +
                            '<td class="text-right">' + datenow + '</td>' +
                            '<td class="text-right subtotal">' + ( $('#product_qty').val() * $('#product_price').val()) + '</td>' +
                            '<td class="text-right"><a href="'+ recordid + '/' + indexid + '" class="edit">Edit</a></td>' +
                        	'</tr>'
						);
						//alert(datenow);
					cnt++;
					Products.GetTotal();	
					
					//alert($('#t0 .edit').attr('href'));
				}
				
			});
			
			saving.fail(function(jqXHR, textStatus, errorThrown) {
				 alert(textStatus + ': ' + errorThrown);				
			});
		},

		Info: function(data){
			//alert(ids.parent().parent().text() );
			//alert(data[0]);
			$('#product_name').val(data[1]);
			$('#product_qty').val(data[2]);
			$('#product_price').val(data[3]);
			$('#submit').text('Update');
			var arr = data[0].split('/');
			$('#record_id').val(arr[0]);
			$('#table_index').val(arr[1]);

			//$('#t0 .prodname').text('asshole');
		
		},

		Check: function(frm){
		
			
			if($('#product_name').val() == ''){
				alert('Product name is required');
			}else if($('#product_qty').val() == 0){
				alert('Quantity is required');
			}else if($('#product_price').val() == ''){
				alert('Price is required');
			}else{
				Products.Save(frm);
			}

			
		},

		GetTotal: function(){
			var sum=0;
			$('.subtotal').each(function() {     
				sum += parseInt($(this).text());                     
			});
			$('.total').text(sum);
		}
		
		
	};	
	$('#product_form').submit(function(e){       
      
	  if($('#record_id').val() != ''){
		$('#t' + $('#table_index').val() + ' .prodname').text($('#product_name').val());
		$('#t' + $('#table_index').val() + ' .prodqty').text($('#product_qty').val());
		$('#t' + $('#table_index').val() + ' .prodprice').text($('#product_price').val());
		
		$('#t' + $('#table_index').val() + ' .subtotal').text($('#product_qty').val() * $('#product_price').val());
		  Products.GetTotal();
		  Products.Check($(this));
	  }else{
		  Products.Check($(this));
		  
	  }
        e.preventDefault();
    });

	$( ".edit" ).each(function( index ) {
        $(this).click(function(e){
			e.preventDefault();           
			var row = $(this).closest("tr");    // Find the row
    		var prodname = row.find(".prodname").text(); // Find the text
			var prodqty = row.find(".prodqty").text(); // Find the text
			var prodprice = row.find(".prodprice").text(); // Find the text
			Products.Info([$(this).attr('href'), prodname, prodqty, prodprice, $(this)]);
        });
        
    });

	

});