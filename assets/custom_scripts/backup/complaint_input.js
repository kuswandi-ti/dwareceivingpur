$(document).ready(function() {
	// 20 Agustus 2018
	// Jika sudah jam 16.00, refresh ke halaman lain (tidak bisa input)
	setInterval(function() {
		var d = new Date();
		var n = d.getHours();
		if (n >= 16) {
			window.location = "complaint_close";
		}
	}, 1000);
	
    $('.select2').select2();

    var current_date = new moment ().format("DD-MM-YYYY");
    $('#txtcomplaintdate_all').val(current_date);

    var current_time = new moment ().format("HH:mm:ss");
    $('#txtcomplainttime_all').val(current_time);
	
	$('#form_crp input[type=radio]').change(function() {       
		var id = this.id;
		
		if (id == 'rdoca_all') {
			$('#ca').show();
			$('#ch').hide();
			$('#ce').hide();
		} else if (id == 'rdoch_all') {
			$('#ca').hide();
			$('#ch').show();
			$('#ce').hide();
		} else if (id == 'rdoce_all') {
			$('#ca').hide();
			$('#ch').hide();
			$('#ce').show();
		}
	});

    $("#cboapplication_ca").on('change', function() {
		var app_name = $(this).val();
		var opt = '<option selected hidden value="0">Pilih Modul</option>';
		$.ajax({
			url: 'complaint_input/get_modul/'+app_name,
			dataType: 'json',
			type: 'get',
			success: function(json) {
				$.each(json, function(i, obj) {
					opt += "<option value='"+obj.sysid+"'>"+obj.menu_name+"</option>";
				});
				$("#cbomodul_ca").html(opt);
			}
		});
	});

    $('#btnsubmit').on('click', function() {
		var departemen_all = $('#cbodepartment_all').val();
		var username_all = $('#txtusername_all').val();
		var noext_all = $('#txtnoext_all').val();
		
        var application_ca = $('#cboapplication_ca').val();
        var modul_ca = $('#cbomodul_ca').val();
        var problemdescription_ca = $('#txtproblemdescription_ca').val();
        var file_ca = $("input[type=file][name=file_ca]").val();

        var computername_ch = $('#cbocomputername_ch').val();
        var problemdescription_ch = $('#txtproblemdescription_ch').val();

        var accountemail_ce = $('#txtaccountemail_ce').val();
        var problemdescription_ce = $('#txtproblemdescription_ce').val();
        var file_ce = $("input[type=file][name=file_ce]").val();
		
		if (departemen_all == 0) {
			$('.info-departemen_all').show();
			$('.info-departemen_all').addClass('text-danger');
			return false;
		} else {
			$('.info-departemen_all').removeClass('text-danger');
			$('.info-departemen_all').hide();
		}
		if (username_all.length < 1) {
			$('.info-username_all').show();
			$('.info-username_all').addClass('text-danger');
			return false;
		} else {
			$('.info-username_all').removeClass('text-danger');
			$('.info-username_all').hide();
		}
		if (noext_all.length < 1) {
			$('.info-noext_all').show();
			$('.info-noext_all').addClass('text-danger');
			return false;
		} else {
			$('.info-noext_all').removeClass('text-danger');
			$('.info-noext_all').hide();
		}

        if ($('#rdoca_all').is(":checked")) {
            if (application_ca == 0) {
				$('.info-application_ca').addClass('text-danger');
                $('.info-application_ca').show();
				return false;
			} else {
                $('.info-application_ca').removeClass('text-danger');
                $('.info-application_ca').hide();
			}
            if (modul_ca == 0) {
				$('.info-modul_ca').addClass('text-danger');
                $('.info-modul_ca').show();
				return false;
			} else {
                $('.info-modul_ca').removeClass('text-danger');
                $('.info-modul_ca').hide();
			}
            if (problemdescription_ca.length < 1) {
                $('.info-problemdescription_ca').addClass('text-danger');
                $('.info-problemdescription_ca').show();
                return false;
            } else {
                $('.info-problemdescription_ca').removeClass('text-danger');
                $('.info-problemdescription_ca').hide();
            }
            if (file_ca.length < 1) {
                $('.info-file_ca').addClass('text-danger');
                $('.info-file_ca').show();
                return false;
			} else {
                $('.info-file_ca').removeClass('text-danger');
                $('.info-file_ca').hide();
            }
        }

        if ($('#rdoch_all').is(":checked")) {
            if (computername_ch == 0) {
				$('.info-computername_ch').addClass('text-danger');
                $('.info-computername_ch').show();
				return false;
			} else {
                $('.info-computername_ch').removeClass('text-danger');
                $('.info-computername_ch').hide();
			}
            if (problemdescription_ch.length < 1) {
                $('.info-problemdescription_ch').addClass('text-danger');
                $('.info-problemdescription_ch').show();
                return false;
            } else {
                $('.info-problemdescription_ch').removeClass('text-danger');
                $('.info-problemdescription_ch').hide();
            }
        }

        if ($('#rdoce_all').is(":checked")) {
            if (accountemail_ce.length < 1) {
                $('.info-accountemail_ce').addClass('text-danger');
                $('.info-accountemail_ce').show();
                return false;
            } else {
                $('.info-accountemail_ce').removeClass('text-danger');
                $('.info-accountemail_ce').hide();
            }
            if (problemdescription_ce.length < 1) {
                $('.info-problemdescription_ce').addClass('text-danger');
                $('.info-problemdescription_ce').show();
                return false;
            } else {
                $('.info-problemdescription_ce').removeClass('text-danger');
                $('.info-problemdescription_ce').hide();
            }
            if (file_ce.length < 1) {
                $('.info-file_ce').addClass('text-danger');
                $('.info-file_ce').show();
                return false;
			} else {
                $('.info-file_ce').removeClass('text-danger');
                $('.info-file_ce').hide();
            }
        }

        var form = $('#form_crp')[0];
		var formData = new FormData(form);

        formData.append('cboapplication_ca', $("#cboapplication_ca").val());
        formData.append('cbomodul_ca', $("#cbomodul_ca").val());
        formData.append('cbocomputername_ch', $("#cbocomputername_ch").val());
        formData.append('cbodepartmentcode_all', $('#cbodepartment_all option:selected').attr('dept_code'));

        $.ajax({
            type: 'post',
            url: 'complaint_input/create_complaint',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
			beforeSend: function() {
				$("body").mLoading('show'); 
			},
            success: function(data) {
				$("body").mLoading('hide');
                alert("Nomor Complaint Problem anda : "+data.doc_no+"\nSilahkan cek di monitoring");
                $(location).attr('href', 'complaint_list');
            },
            error: function() {
				$("body").mLoading('hide');
                alert("process failure");
            }
        });
    });
})