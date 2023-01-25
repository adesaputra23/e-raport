@php
    use App\RoleUser;
    use App\User;
@endphp

@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Data User'])

    <link href={{ asset('assets/libs/select2/css/select2.min.css') }} rel="stylesheet" type="text/css">
    <link href={{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }} rel="stylesheet">
    <link href={{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }} rel="stylesheet" type="text/css">
    <link href={{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }} rel="stylesheet">

    @include('partials/head-css')
</head>

@include('partials/body')
<!-- Begin page -->
<div id="layout-wrapper">
    @include('partials/menu')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('partials/page-title', [
                    'pagetitle' => 'Dashboard',
                    'title' => 'Data User ' . $sidebar_partial,
                ])
                @include('partials/alert_mesage')

                {{-- isi conten --}}
                <div class="card card-body">
                    <div>
                        <table id="datatable"
                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>
                                        @if ($sidebar_partial === 'pegawai')
                                            NIK/NIDN
                                        @else
                                            NISN
                                        @endif
                                    </th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Tanggal Buat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($list_user as $keys => $user)
                                    <tr>
                                        <td>{{ $user->user_code }}</td>
                                        <td>{{ User::GetNameUser($sidebar_partial, $user->user_code) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{!! RoleUser::GetRoles($user->user_code) !!} </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td style="width: 10%">
                                            <div class="btn-group float-center" role="group"
                                                aria-label="Basic example">
                                                @if ($sidebar_partial === 'pegawai')
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        id="btn-set-role" data-bs-toggle="modal"
                                                        data-bs-target=".bs-example-modal-center"
                                                        data-usercode={{ $user->user_code }}
                                                        @if (User::GetNameUser($sidebar_partial, $user->user_code) === 'ADMIN')
                                                            disabled
                                                        @endif
                                                    >Set Role</button>
                                                @endif
                                                <a href="{{ url('/user/reset-password', [$user->user_code]) }}"
                                                    class="btn btn-danger">Res Password</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- end isi conten --}}

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        {{-- Modal set role --}}
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Set Role User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.save.role.admin') }}" method="post">
                        @csrf

                        <div class="modal-body">

                            <input type="hidden" id="user_code" name="user_code" value="">

                            <label class="form-label">User Role</label>

                            <select required name="role[]" id="role" class="select2 form-control select2-multiple"
                                multiple="multiple" data-placeholder="pilih role">
                                @foreach ($list_role as $key => $role)
                                    @if ($role != 'ADMINISTRATOR')
                                        <option value="{{ $key }}">{{ $role }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        </div>

                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{-- End modal set role --}}

        @include('partials/footer')

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@include('partials/right-sidebar')

@include('partials/vendor-scripts')

<script src={{ asset('assets/libs/select2/js/select2.min.js') }}></script>
<script src={{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}></script>
<script src={{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}></script>
<script src={{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}></script>
<script src={{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}></script>
<script src={{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}></script>
<script src={{ asset('assets/js/pages/form-advanced.init.js') }}></script>
<script src={{ asset('assets/js/app.js') }}></script>

<script>
    $(document).ready(function() {
        SetRoleFunc();
        $('.select2').select2({
            dropdownParent: $('.bs-example-modal-center')
        });
    })
</script>

<script>
    // set role function
    function SetRoleFunc() {
        $(document).on('click', '#btn-set-role', function() {
            let user_code = $(this).data('usercode');
            $.ajax({
                url: "{{ route('user.save.role.admin') }}",
                type: "POST",
                data: {
                    user_code: user_code,
                    _token: '{{ csrf_token() }}',
                },
                cache: false,
                dataType: "json",
                success: function(resp) {
                    let is_role = resp.data;
                    $('#user_code').val(user_code);
                    $('.select2').select2('val', [is_role]);
                }
            })
        })
    }
</script>


</body>

</html>
