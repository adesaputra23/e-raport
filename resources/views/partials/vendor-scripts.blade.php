@php
    use App\Http\Controllers\Controller;
@endphp
<!-- JAVASCRIPT -->
<script src={{ asset('assets/libs/jquery/jquery.min.js') }}></script>
<script src={{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}></script>
<script src={{ asset('assets/libs/metismenu/metisMenu.min.js') }}></script>
<script src={{ asset('assets/libs/simplebar/simplebar.min.js') }}></script>
<script src={{ asset('assets/libs/node-waves/waves.min.js') }}></script>

<!-- Required datatable js -->
<script src={{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}></script>
<script src={{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}></script>

<!-- Datatable init js -->
<script src={{ asset('assets/js/pages/datatables.init.js') }}></script>

{{-- validate --}}
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    function counter(time, url) {
        var interval = setInterval(function() {
            $('#waktu').text(time);
            time = time - 1;

            if (time == 0) {
                clearInterval(interval);
                window.location = url;
            }
        }, 1000);
    }

    $("#myform").validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 12,
            },
            confirm_password: {
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: "Masukan Password!",
                minlength: "Password tidak boleh kurang dari 8 karakter",
                maxlength: "Password tidak boleh lebih dari 12 karakter",
            },
            confirm_password: {
                equalTo: "Konfirmasi passwowrd salah!",
            }
        },
        submitHandler: function(form, event) {
            var is_admin = "{!! Controller::isAdminPage() !!}";
            var user_code = $('#user_code').val();
            var pass = $('#password').val();
            var konf_pass = $('#confirm_password');
            $.ajax({
                type: "POST",
                url: "{{ route('ubah.password') }}",
                data: $(form).serialize(),
                dataType: "html",
                cache: false,
                processData: false,
                success: function(response) {
                    var resData = $.parseJSON(response);
                    if (resData == 'Berhasil Ubah Password') {
                        $('#myform').css('display', 'none');
                        $('.ubah-password-modal').css('display', 'block');
                        var url = "{{ route('logout.admin') }}";
                        if (is_admin != 1) {
                            var url = "{{ route('logout') }}";
                        }
                        counter(5, url);
                    } else {
                        alert('gagal');
                    }
                }
            });
            return false;
        }
    });
</script>
