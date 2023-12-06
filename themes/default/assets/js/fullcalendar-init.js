(function(window, document, $, undefined) {
  "use strict";


  	document.addEventListener('DOMContentLoaded', function() {
   
		var date = new Date();
		var m = date.getMonth();
		var y = date.getFullYear();
		var target = $('#calendar');
		target.fullCalendar({
			header: {
				left: 'prev,next,today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			theme: false,
			firstDay: 1,
			selectable: true,
			selectHelper: true,
			editable: true,
			navLinks: true,
			disableDragging: true,
			eventLimit: true,
			displayEventTime : true,
			minTime: '07:00:00',
    		maxTime: '22:00:00',
			slotDuration: '00:30:00',
			slotLabelInterval: {minutes:30},
			slotLabelFormat: 'h(:mm)a',
			slotMinutes: 30,
			columnHeader:true,
			events: {
				url: site.base_url+'staffs/get_appointments',
				error: function() {
					$('#script-warning').show();
				}
			},
				
			select: function (start, end, allDay) {
				console.log(start);
			  console.log(start.isBefore(moment(), 'day'));
	          if(start.isBefore(moment(), 'day')) {

	            $('#calendar').fullCalendar('unselect');

	            return false;

	          }


	            var available_title = "Available";

	            $('#modal_new_event').modal('show');
				$('#modal_new_event #new_event_title').val('Available');
				$('#modal_new_event #allDay').prop('checked', false);
				//$('#modal_new_event #add_event_start_time,#modal_new_event #add_event_end_time').val('').attr('disabled', true);
				$('#modal_new_event #add_event_start_date_label').text(moment(start).format("DD-MMM-YYYY"));

				var event_start_date = moment(start).format("YYYY-MM-DD");
				if(event_start_date){
					$.get(site.base_url+'staffs/get_staffs',
				    {
				        event_start_date: event_start_date
				    },

				    function (data) {
				    
				        $('#staff').html(data);

				    });



				}
				$.get(site.base_url+'staffs/get_services',
			    {
			        event_start_date: event_start_date
			    },

			    function (data) {
			    
			        $('#service').html(data);

			    });

				$.get(site.base_url+'staffs/get_warehouses',
			    {
			        event_start_date: event_start_date
			    },

			    function (data) {
			    
			        $('#location').html(data);

			    });

				$('#modal_new_event #add_event_start_date').val(moment(start).format("YYYY-MM-DD"));
				$('#modal_new_event #add_event_end_date').val(moment(end).format("YYYY-MM-DD"));
				$('#modal_new_event #add_event_start_time').val(moment(start).format("hh:mm a"));
				$('#modal_new_event #add_event_end_time').val(moment(end).format("hh:mm a"));
				target.fullCalendar('unselect');
	            
	        },	
			viewRender: function(view) {
				var calendarDate = $("#calendar").fullCalendar('getDate');
				var calendarMonth = calendarDate.month();
				$('#calendar .fc-toolbar').attr('data-calendar-month', calendarMonth);
				$('.block-header-calendar > h2 > span').html(view.title);
			},
			eventClick: function(event, element) {  
				$('.edit_event_id').val(event.id);
				$('.edit_customer_id').val(event.customer_id);
				$('.edit_event_title').val(event.name);
				$('#modal_edit_event #event_start_date').val(moment(event.start).format("DD-MM-YYYY"));
				$('#modal_edit_event #event_end_date').val(moment(event.start).format("DD-MM-YYYY"));
				$('#modal_edit_event #event_start_time').val(moment(event.start).format("hh:mm a"));
				$('#modal_edit_event #event_end_time').val(moment(event.end).format("hh:mm a"));
				$('#modal_edit_event .edit_event_email').val(event.email);
				$('#modal_edit_event .edit_event_phone').val(event.phone);
				$('#modal_edit_event .edit_event_location').val(event.location);
				$('#modal_edit_event .edit_event_service').val(event.service);
				$('#modal_edit_event .edit_event_staff').val(event.staff);
				
				$('#modal_edit_event .edit_event_description').val(event.description);
				$('#modal_edit_event .edit_reschedule').val(event.reschedule);
				$('#modal_edit_event input[value=' + event.className + ']').prop('checked', true);
				$('#modal_edit_event').modal('show');
				$('#modal_edit_event #error').empty();
				$("#modal_edit_event #cb1").prop('checked', false);
				$('#modal_edit_event #cb1').iCheck("uncheck");
				
				$('#modal_edit_event #cb1').val('0');
				$('#modal_edit_event .already-reschedule-msg').css('display','none');
				$('#modal_edit_event #event_start_date,#modal_edit_event #event_start_time,#modal_edit_event #event_end_date,#modal_edit_event #event_end_time').attr('disabled', true);
				if (event.status == 1) {
					$('#modal_edit_event #event-tag1').prop('checked', true);
					$('#modal_edit_event #event-tag1').iCheck('update')[0].checked;
				} else if (event.status == 2) {
					$('#modal_edit_event #event-tag0').prop('checked', true);
					$('#modal_edit_event #event-tag0').iCheck('update')[0].checked;
				}
			}
		}); 

		//add event
		$(document).on('click', '#btn_add_event', function() {
			var addEventTitle = $('#new_event_title').val();
			var addEventLocation = $('#location').val();
			var addEventStaff = $('#staff').val();
			var addEventService = $('#service').val();
			var addEventMobileNo = $('#add_event_mobile_no').val();
			var addEventName = $('#add_event_name').val();
			var addEventEmail = $('#add_event_email').val();
			var addEventStartDate = $('#add_event_start_date').val();
			var addEventEndDate = $('#add_event_start_date').val();
			var bookedSlot = $('#booked_time').val();
			var description = '';
			
			
			
			var GenRandom = {
				Stored: [],
				Job: function() {
					var newId = Date.now().toString().substr(6);
					if (!this.Check(newId)) {
						this.Stored.push(newId);
						return newId;
					}
					return this.Job();
				},
				Check: function(id) {
					for (var i = 0; i < this.Stored.length; i++) {
						if (this.Stored[i] == id) return true;
					}
					return false;
				}
			};
			console.log(addEventLocation);
			console.log(addEventService);
			console.log(addEventStaff);
			console.log(addEventName);
			console.log(addEventMobileNo);
			console.log(bookedSlot);

			

			if((addEventLocation == 0) || (addEventService == 0) || (addEventStaff == 0) || (bookedSlot == 0 || bookedSlot == '') || (addEventMobileNo == '') || (addEventName == null)) {

				if(addEventName == '' || addEventName == null){
					$('#add_event_name').closest('.form-group').addClass('has-error');
					$('#add_event_name').focus();	
				}
				if(addEventMobileNo == '' || addEventMobileNo == null){
					$('#add_event_mobile_no').closest('.form-group').addClass('has-error');
					$('#add_event_mobile_no').focus();	
				}if(bookedSlot == '' || bookedSlot == 0){
					$('#booked_time').closest('.form-group').addClass('has-error');
					$('#booked_time').focus();	
				}if(addEventStaff == 0){
					$('#staff').closest('.form-group').addClass('has-error');
					$('#staff').focus();	
				}if(addEventService == 0){
					$('#service').closest('.form-group').addClass('has-error');
					$('#service').focus();	
				}
				if(addEventLocation == 0){
					$('#location').closest('.form-group').addClass('has-error');
					$('#location').focus();	
				}
				console.log("b");
			} else {
				console.log("a");

				var bookedTime = $('#booked_time').val().split('-');
				
				var addEventStartTime = bookedTime[0];
				var addEventEndTime = bookedTime[1];
				
				var eventStart = moment(addEventStartDate).add(addEventStartTime).toISOString();
				var eventEnd = moment(addEventEndDate).add(addEventEndTime).toISOString();
					

				var decision = confirm("Are you Sure?");

					if (decision) {

						$.ajax({

						  type: "POST",

						  dataType: "json",

						  url: site.base_url+'appointment/add_appointments',

						  data : { location : addEventLocation, service : addEventService, description : description,staff : addEventStaff,availableslot:bookedSlot,availabledate:addEventStartDate, phone : addEventMobileNo,name : addEventName,email : addEventEmail},
						  success: function (response) {
						  	$('#calendar').fullCalendar('renderEvent', {
								id: response.id,
								title: addEventTitle,
								start: eventStart,
								end: eventEnd,
								allDay: false,
								className: 'qt-fc-event-success',
								description: ''
							}, true);
							$('.form-event')[0].reset()
							$('#modal_new_event').modal('hide');
							$('#new_event_title').closest('.form-group').removeClass('has-error');	
							window.location.reload();
						  	
						  }

						});

					}

					

			}
		});

		//Update/Delete an Event
		
		$('#modal_edit_event').on('click', '[data-calendar]', function() {
			var currentEvent = [];
			var calendarAction = $(this).data('calendar'),
			currentId = $('.edit_event_id').val(),
			currentCustomerId = $('.edit_customer_id').val(),
			currentTitle = $('.edit_event_title').val(),
			currentEmail = $('.edit_event_email').val(),
			currentPhone = $('.edit_event_phone').val(),
			currentStartDate = $('.edit_event_start_date').val(),
			currentStartTime = $('.edit_event_start_time').val(),
			currentStart = currentStartDate+'T'+currentStartTime,
			currentEndDate = $('.edit_event_end_date').val(),
			currentEndTime = $('.edit_event_end_time').val(),
			currentEnd = currentEndDate+'T'+currentEndTime,
			currentStatus = $('input[name=event_tag]:checked').val(),
			currentReschedule = $('input[name=edit_reschedule]').val(),
			currentLocation = $('.edit_event_location').val(),
			currentService = $('.edit_event_service').val(),
			currentStaff = $('.edit_event_staff').val(),
			currentDesc = $('.edit_event_description').val(),
			currentClass = $('input[name=event_tag]:checked').attr("class"),
			currentEvent = $('#calendar').fullCalendar('clientEvents', currentId);
	 		//Update
			if (calendarAction === 'update') {
				if (currentTitle != '') {
					currentEvent[0].id = currentId;
					currentEvent[0].customer_id = currentCustomerId;
					currentEvent[0].title = currentTitle;
					currentEvent[0].name = currentTitle;
					currentEvent[0].status = currentStatus;
					currentEvent[0].reschedule = currentReschedule;
					currentEvent[0].start = currentStart;
					currentEvent[0].end = currentEnd;
					currentEvent[0].allDay = "false";
					currentEvent[0].location = currentLocation;
					currentEvent[0].service = currentService;
					currentEvent[0].staff = currentStaff;
					currentEvent[0].description = currentDesc;
					currentEvent[0].className = currentClass;

					var decision = confirm("Are you Sure?");

					if (decision) {

					$.ajax({

					  type: "POST",
					  dataType: "json",

					  url: site.base_url+'appointment/update_appointment',

					  data : { id : currentId,customer_id : currentCustomerId, name : currentTitle, email : currentEmail, phone : currentPhone, status : currentStatus, description : currentDesc, reschedule : currentReschedule,event_start_date : currentStartDate,event_start_time : currentStartTime,event_end_date : currentEndDate,event_end_time : currentEndTime },
					  success: function (json) {
					  	console.log(json);
			
					  	var status = json.status;
					  	var result = json.data;	
					  	if(status == 200){
						  	$('#calendar').fullCalendar('refetchEvents');
							$('#modal_edit_event').modal('hide');
							Swal.fire(
							'Updated!',
							'Your Appointment has been updated.',
							'success'
							);
							//window.location.reload();
					  	}else
					  	{
							Swal.fire(
							'Error!',
							''+result+'',
							);
						
					  	}
					  	
					  }

					});

					}

					
				} else {
					$('.edit_event_title').closest('.form-group').addClass('has-error');
					$('.edit_event_title').focus();

				}
			}
			//Delete
			if (calendarAction === 'delete') {
				$('#modal_edit_event').modal('hide');
				setTimeout(function() {
					Swal.fire({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, delete it!',
						cancelButtonText: "No, cancel it!"
					}).then((result) => {
			        if (result.value) {
					$.ajax({

					  type: "POST",
					  dataType: "json",

					  url: site.base_url+'appointment/delete_appointment',

					  data : { id : currentId},
					  success: function (json) {
			
					  	console.log(json);
			
					  	var status = json.status;
					  	var result = json.data;	
					  	if(status == 200){
						  	target.fullCalendar('removeEvents', currentId);
							Swal.fire(
							'Deleted!',
							'Your event has been removed.',
							'success'
							);
					  	}else
					  	{
							Swal.fire('Oops...! Something went wrong.');
					  	}
					  	
					  }

					});

					}
					else if (
				          // Read more about handling dismissals
				          result.dismiss === swal.DismissReason.cancel
				        ) {
				          Swal.fire(
				            'Cancelled',
				            'Your Appointment Details is safe :)',
				            'error'
				          )
				        }	
					})
				}, 250);
			}
		});
		
		$('#cb1').on('ifChecked', function () {
			$('#modal_edit_event #cb1').prop('checked', true);
				
        		$('#modal_edit_event #cb1').val('1');
                $('#modal_edit_event .reschedule-msg').css('display','block');
                $('#modal_edit_event #event_start_date,#modal_edit_event #event_start_time,#modal_edit_event #event_end_date,#modal_edit_event #event_end_time').attr('disabled', false);
        });
        $('#cb1').on('ifUnchecked', function () {
        	$('#modal_edit_event #cb1').prop('checked', false);
		        $('#modal_edit_event #cb1').val('0');
                $('#modal_edit_event .reschedule-msg').css('display','none');
                $('#modal_edit_event #event_start_date,#modal_edit_event #event_start_time,#modal_edit_event #event_end_date,#modal_edit_event #event_end_time').attr('disabled', true);
        });

		
		
    
	});
	
	function fmt(date) {

        return date.format("YYYY-MM-DD HH:mm:ss");
    }



})(window, document, window.jQuery);
