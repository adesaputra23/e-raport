@php
    use App\Http\Controllers\Controller;
@endphp
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                E-RAPORT :
                <script>
                    document.write(new Date().getFullYear())
                </script> © SDN ARDISAENG 1.
            </div>
            {{-- <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                </div>
            </div> --}}
        </div>
    </div>
</footer>

{{-- modal seting password --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="ubah-password-modal" style="display: none;">
                <div class="modal-body">
                    <div class="text-center">
                        <h4 class="card-title" id="title">Password berhasil diubah.</h4>
                        <p class="card-title-desc" id="conten">anda akan dilogout secara otomatis dalam waktu <code
                                class="highlighter-rouge" id="waktu"></code></p>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (Controller::isAdminPage())
                        <a href="{{ route('logout.admin') }}" class="btn btn-primary waves-effect waves-light">Ok</a>
                    @else
                        <a href="{{ route('logout') }}" class="btn btn-primary waves-effect waves-light">Ok</a>
                    @endif
                </div>
            </div>

            <form action="" method="" id="myform" style="display: block;">
                @csrf
                <div class="modal-body">
                    <div>
                        <input type="hidden" value="{{ Auth::user()->user_code }}" name="user_code" id="user_code">
                        <div class="input-group mb-3">
                            <label for="example-text-input">Password Baru</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="password" placeholder="Password Baru" id="password"
                                    name="password">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="example-text-input">Konfirmasi Password Baru</label>
                            <div class="col-sm-12">
                                <input class="form-control" type="password" placeholder="Konfirmasi Password Baru"
                                    id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                        id="simpan-ubah-password">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal --}}
