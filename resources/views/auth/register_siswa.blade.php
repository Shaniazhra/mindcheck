<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | MindCheck SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    
    <style>
        :root {
            --navy: #16324B;
            --navy-deep: #0E2338;
            --blue: #4E8FC4;
            --blue-soft: #DCEBF6;
            --bg: #F5F9FC;
            --white: #FFFFFF;
            --leaf: #4C7A52;
            --leaf-soft: #E5EFE6;
            --ink: #16324B;
            --ink-soft: #52687D;
            --line: #D8E6F0;
            --error-bg: #FBEAEA;
            --error-ink: #B4453F;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        h1, h2, h3, .serif { font-family: 'Source Serif 4', Georgia, serif; }

        :focus-visible {
            outline: 3px solid var(--blue);
            outline-offset: 2px;
            border-radius: 4px;
        }

        .page { min-height: 100vh; background: #fff; }

        .card {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: #fff;
            display: flex;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 5px;
            z-index: 5;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }

        /* ===== Brand (dipakai di panel & mobile) ===== */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-text {
            line-height: 1.25;
        }

        .school-name {
            font-family: 'Source Serif 4', Georgia, serif;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .school-sub {
            font-size: 12px;
            font-weight: 500;
            color: #C5D5E3;
        }

        /* ===== Panel kiri ===== */
        .panel {
            width: 42%;
            min-width: 360px;
            max-width: 600px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            align-self: flex-start;
            height: 100vh;
            overflow-y: auto;
            color: #EAF2F8;
            padding: 56px 56px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
        }

        .panel::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(22,50,75,.88) 0%,
                rgba(22,50,75,.82) 45%,
                rgba(14,35,56,.96) 100%
            );
        }

        .panel > * {
            position: relative;
            z-index: 1;
        }

        .panel h2 {
            font-size: 24px;
            line-height: 1.3;
            font-weight: 600;
            margin: 44px 0 14px;
            color: #fff;
        }

        .panel h2 {
            font-size: 30px;
        }

        .panel .lead {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.75;
            color: #D2E0EC;
        }

        .prep {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid rgba(255,255,255,.2);
        }

        .prep h3 {
            margin: 0 0 14px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .prep ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 12px;
        }

        .prep li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 13px;
            line-height: 1.55;
            color: #D2E0EC;
        }

        .prep li svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .panel-foot {
            margin-top: 28px;
            font-size: 12px;
            line-height: 1.6;
            color: #A9BDCF;
        }

        .panel-foot strong {
            display: block;
            color: #fff;
            font-weight: 600;
            margin-bottom: 2px;
        }

        /* ===== Sisi form ===== */
        .form-side {
            flex: 1;
            min-width: 0;
            padding: 64px 56px 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 260px);
        }

        .form-side > * {
            width: 100%;
            max-width: 560px;
            text-align: left;
        }

        .mobile-brand {
            display: none;
            position: relative;
            align-items: center;
            gap: 14px;
            padding: 34px 20px 30px;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
            overflow: hidden;
        }

        .mobile-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(22,50,75,.72) 0%,
                rgba(22,50,75,.9) 100%
            );
        }

        .mobile-brand::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 5px;
            background: linear-gradient(
                90deg,
                var(--navy) 0%,
                var(--blue) 50%,
                var(--leaf) 100%
            );
        }

        .mobile-brand > * {
            position: relative;
            z-index: 1;
        }

        .mobile-brand .brand-mark {
            width: 52px;
            height: 52px;
        }

        .mobile-brand .brand-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .mobile-brand .school-name {
            font-size: 17px;
            text-shadow: 0 1px 6px rgba(0,0,0,.35);
        }

        .mobile-brand .school-sub {
            font-size: 12px;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-soft);
            margin-bottom: 22px;
            transition: color .15s ease;
        }

        .back-home:hover {
            color: var(--navy);
        }

        .form-side h1 {
            font-size: 28px;
            line-height: 1.25;
            font-weight: 600;
            margin: 0 0 8px;
            letter-spacing: -.2px;
            color: var(--navy);
        }

        .form-side .sub {
            font-size: 14px;
            color: var(--ink-soft);
            margin: 0 0 26px;
            line-height: 1.65;
            text-align: left;
        }

        .error-box {
            background: var(--error-bg);
            color: var(--error-ink);
            font-size: 13px;
            border-radius: 8px;
            padding: 13px 16px;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-weight: 500;
            border: 1px solid rgba(180,69,63,.25);
            border-left: 4px solid var(--error-ink);
        }

        .error-box svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 16px;
            display: grid;
            gap: 3px;
        }

        /* Kelompok isian */
        .group {
            margin-bottom: 26px;
        }

        .group-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 0 16px;
            font-family: 'Source Serif 4', Georgia, serif;
            font-size: 17px;
            font-weight: 600;
            color: var(--navy);
        }

        .group-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--line);
        }

        .field {
            margin-bottom: 16px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .field > label,
        .field > .label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 7px;
        }

        .field-hint {
            display: block;
            font-size: 12px;
            color: var(--ink-soft);
            margin-top: 7px;
            line-height: 1.5;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1.5px solid var(--line);
            background: var(--bg);
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--ink);
            transition:
                border-color .15s ease,
                background .15s ease,
                box-shadow .15s ease;
            appearance: none;
        }

        .field input::placeholder {
            color: #8FA4B6;
        }

        .field input:hover,
        .field select:hover {
            border-color: #B9D0E2;
        }

        .field input:focus,
        .field select:focus {
            outline: none;
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(78,143,196,.15);
        }

        .field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2352687D' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
            cursor: pointer;
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .kelas-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            font-size: 12.5px;
            color: var(--ink-soft);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 46px;
            padding: 3px 11px;
            border-radius: 6px;
            background: var(--blue-soft);
            border: 1px solid var(--blue);
            color: var(--navy);
            font-weight: 700;
            font-size: 13px;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-wrap input {
            padding-right: 46px;
        }

        .pw-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            background: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pw-toggle:hover {
            color: var(--navy);
            background: var(--blue-soft);
        }

        .pw-match {
            min-height: 18px;
        }

        .pw-match.ok {
            color: var(--leaf);
            font-weight: 600;
        }

        .pw-match.no {
            color: var(--error-ink);
            font-weight: 600;
        }

        .btn-submit {
            width: 100%;
            background: var(--navy);
            color: #fff;
            border: 1.5px solid var(--navy);
            font-family: inherit;
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 6px;
            transition: background .15s ease, transform .12s ease;
        }

        .btn-submit:hover {
            background: var(--navy-deep);
        }

        .btn-submit:active {
            transform: scale(.99);
        }

        .btn-submit:disabled {
            opacity: .7;
            cursor: wait;
        }

        .privacy-note {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            margin-top: 16px;
            font-size: 12px;
            line-height: 1.6;
            color: var(--ink-soft);
        }

        .privacy-note svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .footer-link {
            text-align: center;
            font-size: 14px;
            color: var(--ink-soft);
            margin: 26px 0 0;
            padding-top: 22px;
            border-top: 1px solid var(--line);
        }

        .footer-link a {
            color: var(--navy);
            font-weight: 700;
            border-bottom: 1.5px solid var(--blue);
            padding-bottom: 1px;
        }

        .footer-link a:hover {
            color: var(--blue);
        }

        /* ===== Responsif ===== */
        @media (max-width: 1100px) {
            .panel {
                width: 38%;
                min-width: 320px;
                padding: 48px 36px 32px;
            }

            .form-side {
                padding: 56px 40px 44px;
            }
        }

        @media (max-width: 760px) {
            .card {
                flex-direction: column;
            }

            .card::before {
                display: none;
            }

            .panel {
                display: none;
            }

            .mobile-brand {
                display: flex;
            }

            .form-side {
                padding: 26px 22px 40px;
                background: #fff;
            }

            .back-home {
                margin-bottom: 18px;
            }

            .form-side h1 {
                font-size: 23px;
            }
        }

        @media (max-width: 480px) {
            .form-side {
                padding: 22px 16px 34px;
            }

            .form-side h1 {
                font-size: 21px;
            }

            .form-side .sub {
                font-size: 13px;
                margin-bottom: 22px;
            }

            .field input,
            .field select {
                padding: 11px 13px;
                font-size: 14px;
            }

            .field select {
                padding-right: 36px;
            }

            .row-2 {
                gap: 10px;
            }

            .row-pw {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .btn-submit {
                padding: 13px;
                font-size: 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
            }
        }
    </style>
</head>

<body>

<div class="page">
    <div class="card">

    {{-- Sidebar registrasi siswa --}}
@include('partials.panel_regist_siswa')

        {{-- Form --}}
        <main class="form-side">

            <a href="/" class="back-home">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M15 6l-6 6 6 6"/>
                </svg>
                Kembali ke beranda
            </a>

            <h1>Buat akun siswa</h1>

            <p class="sub">
                Isi data diri dengan benar sesuai data sekolah agar akunmu dapat dikenali oleh Guru BK.
            </p>

            @if($errors->any())
                <div class="error-box" role="alert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                              stroke="#B4453F"
                              stroke-width="1.8"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>

                    @if($errors->count() > 1)
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span>{{ $errors->first() }}</span>
                    @endif
                </div>
            @endif

            <form method="POST" action="/register" id="registerForm">
                @csrf

                {{-- Data diri --}}
                <section class="group">
                    <h2 class="group-title">Data diri</h2>

                    <div class="field">
                        <label for="nama">Nama lengkap</label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') }}"
                            required
                            autocomplete="name"
                            placeholder="Nama sesuai absen"
                        >
                    </div>

                    <div class="row-2">

                        <div class="field">
                            <label for="nis">NIS</label>

                            <input
                                type="text"
                                id="nis"
                                name="nis"
                                value="{{ old('nis') }}"
                                required
                                inputmode="numeric"
                                autocomplete="off"
                                placeholder="Contoh: 20313"
                            >

                            <span class="field-hint">
                                Tertera di absen atau kartu pelajar.
                            </span>
                        </div>

                        <div class="field">
                            <label for="jenis_kelamin">Jenis kelamin</label>

                            <select id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>
                                    Pilih jenis kelamin
                                </option>

                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- TAMBAHAN: Nomor telepon --}}
                    <div class="field">
                        <label for="no_telp">Nomor telepon</label>

                        <input
                            type="tel"
                            id="no_telp"
                            name="no_telp"
                            value="{{ old('no_telp') }}"
                            required
                            inputmode="tel"
                            autocomplete="tel"
                            placeholder="Contoh: 081234567890"
                        >

                        <span class="field-hint">
                            Nomor telepon yang masih aktif.
                        </span>
                    </div>

                </section>

                {{-- Kelas --}}
                <section class="group">
                    <h2 class="group-title">Kelas</h2>

                    <div class="field">
                        <span class="label" id="labelKelas">
                            Tingkat dan nomor kelas
                        </span>

                        <div class="row-2">

                            <select id="tingkat" required aria-labelledby="labelKelas">
                                <option value="" disabled {{ old('tingkat') ? '' : 'selected' }}>
                                    Tingkat
                                </option>

                                <option value="7" {{ old('tingkat') == '7' ? 'selected' : '' }}>
                                    Kelas 7
                                </option>

                                <option value="8" {{ old('tingkat') == '8' ? 'selected' : '' }}>
                                    Kelas 8
                                </option>

                                <option value="9" {{ old('tingkat') == '9' ? 'selected' : '' }}>
                                    Kelas 9
                                </option>
                            </select>

                            <select id="rombel" required aria-label="Nomor kelas">
                                <option value="" disabled {{ old('rombel') ? '' : 'selected' }}>
                                    Nomor kelas
                                </option>

                                @for($n = 1; $n <= 10; $n++)
                                    <option value="{{ $n }}" {{ old('rombel') == (string) $n ? 'selected' : '' }}>
                                        {{ $n }}
                                    </option>
                                @endfor
                            </select>

                        </div>

                        <span class="kelas-preview">
                            Kode kelas kamu:
                            <span class="chip" id="kelasChip">–</span>
                        </span>

                        <input
                            type="hidden"
                            id="kelas"
                            name="kelas"
                            value="{{ old('kelas') }}"
                        >
                    </div>

                    <div class="field">
                        <label for="tahun_ajaran">Tahun ajaran</label>

                        <select id="tahun_ajaran" name="tahun_ajaran" disabled>
                            <option selected>Memuat…</option>
                        </select>

                        <span class="field-hint">
                            Tahun ajaran berjalan, sama untuk semua kelas.
                        </span>
                    </div>
                </section>

                {{-- Akun --}}
                <section class="group">
                    <h2 class="group-title">Akun</h2>

                    <div class="field">
                        <label for="email">Email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="email@kamu.com"
                        >
                    </div>

                    <div class="row-2 row-pw">

                        <div class="field">
                            <label for="password">Password</label>

                            <div class="pw-wrap">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    minlength="6"
                                    autocomplete="new-password"
                                    placeholder="Minimal 6 karakter"
                                >

                                <button
                                    type="button"
                                    class="pw-toggle"
                                    onclick="togglePw('password', this)"
                                    aria-label="Tampilkan atau sembunyikan password"
                                >
                                    <svg
                                        class="eye-off"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M1 1l22 22"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />
                                    </svg>

                                    <svg
                                        class="eye-on"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        style="display:none"
                                    >
                                        <path
                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="field">
                            <label for="password_confirmation">
                                Ulangi password
                            </label>

                            <div class="pw-wrap">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ketik ulang password"
                                >

                                <button
                                    type="button"
                                    class="pw-toggle"
                                    onclick="togglePw('password_confirmation', this)"
                                    aria-label="Tampilkan atau sembunyikan konfirmasi password"
                                >
                                    <svg
                                        class="eye-off"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >
                                        <path
                                            d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M1 1l22 22"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                        />
                                    </svg>

                                    <svg
                                        class="eye-on"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        style="display:none"
                                    >
                                        <path
                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <span
                                class="field-hint pw-match"
                                id="pwMatch"
                                aria-live="polite"
                            ></span>
                        </div>

                    </div>
                </section>

                <button
                    type="submit"
                    class="btn-submit"
                    id="btnSubmit"
                >
                    Daftar sekarang
                </button>

                <p class="privacy-note">
                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M12 2L3 6v6c0 5 3.8 8.7 9 10 5.2-1.3 9-5 9-10V6l-9-4z"
                            stroke="#4E8FC4"
                            stroke-width="1.7"
                            stroke-linejoin="round"
                        />
                    </svg>

                    <span>
                        Data yang kamu isi bersifat rahasia dan hanya digunakan
                        untuk keperluan layanan Bimbingan &amp; Konseling.
                    </span>
                </p>
            </form>

            <p class="footer-link">
                Sudah punya akun?
                <a href="/login">Masuk di sini</a>
            </p>

        </main>
    </div>
</div>

<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const off = btn.querySelector('.eye-off');
        const on = btn.querySelector('.eye-on');

        if (input.type === 'password') {
            input.type = 'text';
            off.style.display = 'none';
            on.style.display = 'block';
        } else {
            input.type = 'password';
            off.style.display = 'block';
            on.style.display = 'none';
        }
    }

    // Gabungkan Tingkat + Rombel jadi satu kode kelas
    // contoh: 7-1, 8-2, 9-10
    const tingkatEl = document.getElementById('tingkat');
    const rombelEl = document.getElementById('rombel');
    const kelasHidden = document.getElementById('kelas');
    const kelasChip = document.getElementById('kelasChip');
    const tahunAjaranEl = document.getElementById('tahun_ajaran');

    function updateKelasCode() {
        const t = tingkatEl.value;
        const r = rombelEl.value;

        if (t && r) {
            const kode = `${t}-${r}`;

            kelasHidden.value = kode;
            kelasChip.textContent = kode;
        } else {
            kelasHidden.value = '';
            kelasChip.textContent = '–';
        }

        updateTahunAjaran();
    }

    function updateTahunAjaran() {
        // Tahun ajaran SAMA untuk semua kelas (dimulai bulan Juli).
        // Yang berbeda antar tingkat hanya angkatan (tahun masuk),
        // dan itu dihitung otomatis oleh server dari kelas.
        const now = new Date();
        const tahunAwal = (now.getMonth() + 1) >= 7
            ? now.getFullYear()
            : now.getFullYear() - 1;
        const kode = `${tahunAwal}/${tahunAwal + 1}`;

        tahunAjaranEl.innerHTML = `
            <option value="${kode}" selected>${kode}</option>
        `;
    }

    updateTahunAjaran();

    tingkatEl.addEventListener('change', updateKelasCode);
    rombelEl.addEventListener('change', updateKelasCode);

    // Kalau ada old('kelas') dari validasi backend
    // (mis. "7-1"), pecah lagi ke dua select
    (function restoreOldKelas() {
        const oldVal = kelasHidden.value;

        if (oldVal && oldVal.includes('-')) {
            const [t, r] = oldVal.split('-');

            tingkatEl.value = t;
            rombelEl.value = r;

            updateKelasCode();
        }
    })();

    // Penanda password sama / belum sama
    const pw = document.getElementById('password');
    const pwConf = document.getElementById('password_confirmation');
    const pwMatch = document.getElementById('pwMatch');

    function checkMatch() {
        if (!pwConf.value) {
            pwMatch.textContent = '';
            pwMatch.className = 'field-hint pw-match';
        } else if (pw.value === pwConf.value) {
            pwMatch.textContent = 'Password sudah sama.';
            pwMatch.className = 'field-hint pw-match ok';
        } else {
            pwMatch.textContent = 'Password belum sama.';
            pwMatch.className = 'field-hint pw-match no';
        }
    }

    pw.addEventListener('input', checkMatch);
    pwConf.addEventListener('input', checkMatch);

    // Pastikan kode kelas terbentuk sebelum form dikirim,
    // dan cegah klik ganda
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        updateKelasCode();

        if (!kelasHidden.value) {
            e.preventDefault();

            alert('Silakan pilih tingkat dan nomor kelas terlebih dahulu.');

            return;
        }

        const btn = document.getElementById('btnSubmit');

        btn.disabled = true;
        btn.textContent = 'Memproses...';
    });
</script>

</body>
</html>