@include('layouts.partials.main')

<head>
    <?php
    $title = 'Register & Signup'; ?>

    @include('layouts.partials.title-meta')
    @include('layouts.partials.head-css')

</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-brand">
                                    <a href="index.php" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                                height="50">
                                        </span>
                                    </a>

                                    <a href="index.php" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                                height="50">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Don't have an account? Create your account, it takes
                                    less than a minute</p>
                            </div>

                            <form action="{{ route('user.daftar') }}" method="POST" class="parsley-examples">
                                @csrf

                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" value="{{ old('email') }}" required
                                        placeholder="Enter your email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" id="phone" min="0"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Nama Perusahaan / Usaha</label>
                                    <input class="form-control @error('company_name') is-invalid @enderror"
                                        type="text" id="company_name" name="company_name"
                                        value="{{ old('company_name') }}" placeholder="Enter your company name"
                                        required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        <small class="form-text text-muted">
                                            Kata sandi harus mengandung setidaknya satu huruf kecil, satu huruf besar,
                                            satu angka dan satu karakter khusus (@$!%*?&)
                                        </small>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="agreeCheckbox">
                                        <label class="form-check-label" for="checkbox-signup">Saya setuju <a
                                                href="javascript:void(0)" class="text-dark" data-bs-toggle="modal"
                                                data-bs-target="#termsModal">dengan ketentuan pengguna
                                                Fintek Indonesia</a></label>
                                    </div>
                                </div>
                                <div class="text-center d-grid">
                                    <button class="btn btn-success" type="submit" id="submitButton" disabled> Sign Up
                                    </button>
                                </div>

                            </form>

                            <div class="text-center">
                                <h5 class="mt-3 text-muted">Sign up using</h5>
                                <ul class="social-list list-inline mt-3 mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);"
                                            class="social-list-item border-primary text-primary"><i
                                                class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);"
                                            class="social-list-item border-danger text-danger"><i
                                                class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);"
                                            class="social-list-item border-info text-info"><i
                                                class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);"
                                            class="social-list-item border-secondary text-secondary"><i
                                                class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Already have account? <a href="{{ route('login') }}"
                                    class="text-white ms-1"><b>Sign In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Ketentuan Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <h4>Syarat dan Ketentuan Penggunaan</h4>
                    <p>Selamat datang di Fintek Mutiara Indonesia. Dengan menggunakan layanan kami, Anda menyetujui
                        syarat dan ketentuan berikut:</p>

                    <h5>1. Pendaftaran Akun</h5>
                    <ul>
                        <li>Anda harus memberikan informasi yang akurat dan lengkap saat mendaftar</li>
                        <li>Anda bertanggung jawab untuk menjaga kerahasiaan akun Anda</li>
                        <li>Anda harus berusia minimal 18 tahun atau usia legal di wilayah Anda</li>
                    </ul>

                    <h5>2. Penggunaan Layanan</h5>
                    <ul>
                        <li>Layanan hanya boleh digunakan untuk tujuan yang legal</li>
                        <li>Dilarang menyalahgunakan layanan untuk aktivitas yang merugikan</li>
                        <li>Kami berhak membatasi atau menghentikan akses jika terjadi pelanggaran</li>
                    </ul>

                    <h5>3. Privasi dan Keamanan</h5>
                    <ul>
                        <li>Kami menjaga kerahasiaan data pribadi Anda sesuai kebijakan privasi</li>
                        <li>Anda wajib melaporkan segala aktivitas mencurigakan pada akun Anda</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer footer-alt">
        2015 -
        <script>
            document.write(new Date().getFullYear())
        </script> &copy; &nbsp<a href="" class="text-white-50">Fintek Mutiara Indonesia</a>
    </footer>

    <!-- Authentication js -->
    {{-- <script src="{{ asset('assets/js/pages/authentication.init.js') }}"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('agreeCheckbox');
            const button = document.getElementById('submitButton');

            checkbox.addEventListener('change', function() {
                button.disabled = !this.checked;
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.querySelector('.input-group-text[data-password]');
            const passwordInput = document.getElementById('password');
            const eye = toggle.querySelector('.password-eye');

            toggle.addEventListener('click', function() {
                const isHidden = toggle.getAttribute('data-password') === 'false';
                passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
                toggle.setAttribute('data-password', isHidden ? 'true' : 'false');

                // Ganti icon jika perlu (misalnya pakai CSS class atau innerHTML)
                eye.classList.toggle('show'); // kamu bisa definisikan style berbeda untuk .show
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..."
        crossorigin="anonymous"></script>

</body>

</html>
