<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Absensi Siswa - {{ $class->name ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=JetBrains+Mono:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* 60% Dominant: Modern Crisp Pure White */
            --bg-card:       #ffffff;
            --bg-surface:    #f8fafc;
            --border-light:  #e2e8f0;
            --border-card:   #cbd5e1;

            /* 30% Secondary: Structured Institutional Deep Navy */
            --navy-dark:     #0f172a;
            --navy-mid:      #1e3a5f;
            --navy-sub:      #334155;
            --text-main:     #0f172a;
            --text-muted:    #64748b;

            /* 10% Accent: Refined Government Gold / Amber */
            --gold-accent:   #d97706;
            --gold-light:    #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0b1324;
            min-height: 100vh;
            padding: 24px;
            color: #e2e8f0;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Action Bar (Screen Only) ── */
        .action-bar {
            max-width: 980px;
            margin: 0 auto 28px;
            background: #111c33;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }
        .action-bar-left { display: flex; align-items: center; gap: 14px; }
        .back-btn {
            display: flex; align-items: center; justify-content: center;
            width: 38px; height: 38px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #94a3b8;
            text-decoration: none;
            transition: all .2s ease;
        }
        .back-btn:hover { background: rgba(255, 255, 255, 0.14); color: #fff; transform: translateX(-2px); }
        .action-bar h1 { font-size: 15px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .action-bar p { font-size: 11.5px; color: #94a3b8; margin-top: 3px; }
        .btn-print {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #1e40af, #1e3a5f);
            color: #fff; font-size: 12px; font-weight: 700;
            padding: 10px 22px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.2); cursor: pointer;
            box-shadow: 0 4px 14px rgba(30, 64, 175, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            transition: all .2s ease;
        }
        .btn-print:hover { background: linear-gradient(135deg, #2563eb, #1e40af); transform: translateY(-1px); }
        .btn-print:active { transform: scale(0.98); }

        /* ── Cards Grid ── */
        .cards-grid {
            max-width: 980px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 26px;
        }

        /* ── Card Wrapper with Crisp Cut Guide ── */
        .card-wrapper {
            padding: 3px;
            border-radius: 16px;
            border: 1.5px dashed rgba(148, 163, 184, 0.35);
            transition: transform .2s ease, border-color .2s ease;
        }
        .card-wrapper:hover {
            border-color: rgba(217, 119, 6, 0.6);
            transform: translateY(-2px);
        }

        /* ── Standard Portrait ID Card (CR-80: 54mm × 85.6mm) ── */
        .id-card {
            width: 222px;
            min-height: 352px;
            background: var(--bg-card);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 14px 38px rgba(0, 0, 0, 0.45), 0 2px 6px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--border-card);
            display: flex;
            flex-direction: column;
            position: relative;
            user-select: none;
        }

        /* Top Accent Strip (Dual Color) */
        .card-top-bar {
            height: 3.5px;
            width: 100%;
            background: linear-gradient(90deg, #1e3a5f 0%, #d97706 50%, #1e3a5f 100%);
            flex-shrink: 0;
        }

        /* ── Modern Card Header ── */
        .card-header-box {
            padding: 10px 10px 8px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 7px;
            border-bottom: 1px solid var(--border-light);
            flex-shrink: 0;
        }
        .header-logo-wrap {
            width: 28px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .header-logo-wrap img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }
        .header-logo-fallback {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            background: #1e3a5f;
            color: #fff;
            font-size: 11px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header-text-wrap {
            flex: 1;
            text-align: center;
            min-width: 0;
            padding: 0 2px;
        }
        /* Full school name display: wraps cleanly on 2 lines, never truncated with ... */
        .header-inst-title {
            font-size: 8px;
            font-weight: 900;
            color: var(--navy-dark);
            text-transform: uppercase;
            letter-spacing: .01em;
            line-height: 1.25;
            text-align: center;
            word-wrap: break-word;
        }
        .header-inst-sub {
            font-size: 5.4px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* ── Card Title Ribbon (Crisp Modern Bar) ── */
        .card-title-bar {
            margin: 6px 10px 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-left: 3px solid var(--gold-accent);
            border-right: 3px solid var(--gold-accent);
            border-radius: 4px;
            padding: 3.5px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
            flex-shrink: 0;
        }
        .card-title-text {
            font-size: 6.4px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: .12em;
            text-transform: uppercase;
            text-align: center;
        }

        /* ── Student Information Block ── */
        .student-block {
            padding: 8px 10px 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }
        .student-name-text {
            font-size: 13.5px;
            font-weight: 900;
            color: var(--navy-dark);
            text-transform: uppercase;
            letter-spacing: .02em;
            text-align: center;
            line-height: 1.15;
            max-width: 205px;
            word-break: break-word;
        }

        /* Metadata Two-Column Grid */
        .meta-grid {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
        }
        .meta-box {
            padding: 3px 5px;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1.15;
        }
        .meta-box-nisn {
            background: #f8fafc;
            border: 1px solid var(--border-card);
        }
        .meta-box-class {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }
        .meta-box-label {
            font-size: 5px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .meta-box-value {
            font-size: 7.2px;
            font-weight: 800;
            color: var(--navy-dark);
            letter-spacing: .02em;
        }
        .font-mono-num {
            font-family: 'JetBrains Mono', monospace;
        }

        /* ── Giant QR Code Area (Maximized Surface) ── */
        .qr-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3px 10px 5px;
            gap: 5px;
        }
        .qr-frame {
            position: relative;
            padding: 7px;
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Crisp Sharp Corner Registration Brackets */
        .qr-corner {
            position: absolute;
            width: 13px;
            height: 13px;
            border-color: var(--gold-accent);
            border-style: solid;
        }
        .corner-tl { top: 0; left: 0; border-width: 2.5px 0 0 2.5px; border-radius: 2px 0 0 0; }
        .corner-tr { top: 0; right: 0; border-width: 2.5px 2.5px 0 0; border-radius: 0 2px 0 0; }
        .corner-bl { bottom: 0; left: 0; border-width: 0 0 2.5px 2.5px; border-radius: 0 0 0 2px; }
        .corner-br { bottom: 0; right: 0; border-width: 0 2.5px 2.5px 0; border-radius: 0 0 2px 0; }

        .qr-frame svg, .qr-frame img {
            display: block;
            width: 144px;
            height: 144px;
        }

        .qr-caption-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
        }
        .caption-hairline {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }
        .caption-text {
            font-size: 5.6px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text-muted);
            white-space: nowrap;
        }

        /* ── Card Footer (Clean & Professional, Tanpa Badge Aktif) ── */
        .card-footer {
            background: #f8fafc;
            border-top: 1px solid var(--border-light);
            padding: 7px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .footer-ta {
            font-size: 6.8px;
            font-weight: 800;
            color: var(--navy-sub);
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: .03em;
        }
        .footer-brand {
            font-size: 7px;
            font-weight: 800;
            color: var(--navy-mid);
            letter-spacing: .04em;
        }

        /* Bottom Accent Strip */
        .card-bottom-bar {
            height: 3px;
            width: 100%;
            background: linear-gradient(90deg, #1e3a5f 0%, #d97706 50%, #1e3a5f 100%);
            flex-shrink: 0;
        }

        /* ── Empty State ── */
        .empty-state {
            width: 100%; text-align: center; padding: 48px 24px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px; color: #94a3b8;
            font-size: 13px;
        }

        /* ── Print Styles ── */
        @media print {
            @page {
                size: A4 portrait;
                margin: 7mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            .cards-grid {
                gap: 5mm !important;
                justify-content: flex-start !important;
            }
            .card-wrapper {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                border: 0.5px dashed #cbd5e1 !important;
                padding: 1px !important;
                box-shadow: none !important;
            }
            .id-card {
                box-shadow: none !important;
                border: 1px solid #94a3b8 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Hidden during Print) -->
    <div class="action-bar no-print">
        <div class="action-bar-left">
            <a href="{{ route('admin.qr-cards.index') }}" class="back-btn" title="Kembali ke Menu Kartu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1>Pratinjau Cetak Kartu Absensi Siswa</h1>
                <p>
                    {{ $students->count() === 1 ? 'Siswa: ' . $students->first()->name : 'Kelas: ' . ($class->name ?? '-') . ' (' . $students->count() . ' siswa)' }}
                </p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <button onclick="window.print()" class="btn-print">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.615 0-1.11-.474-1.12-1.078L6 18m11.66 0h-11.66m11.66 0a3.921 3.921 0 0 0-3.16-3.921m-5.34 0a3.921 3.921 0 0 0-3.16 3.921m7.437-11.62L16.55 3H7.45L6.063 6.38M16.547 9a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Z"/>
                </svg>
                Cetak Kartu Sekarang
            </button>
        </div>
    </div>

    <!-- Printable Cards Grid -->
    <div class="cards-grid">
        @forelse($students as $student)
        <div class="card-wrapper no-break">
            <div class="id-card">

                <!-- Top Accent Strip -->
                <div class="card-top-bar"></div>

                <!-- Modern ID Card Header (Bukan Kop Surat, Nama Lengkap Tanpa Ellipsis) -->
                <div class="card-header-box">
                    <!-- Logo Jawa Barat (Kiri) -->
                    <div class="header-logo-wrap" title="Provinsi Jawa Barat">
                        @if(file_exists(public_path('images/logo-jabar.svg')))
                            <img src="{{ asset('images/logo-jabar.svg') }}" alt="Logo Jabar">
                        @else
                            <div class="header-logo-fallback">JB</div>
                        @endif
                    </div>

                    <!-- Judul Sekolah (Tampil Lengkap, Wrap Rapi Tanpa ...) -->
                    <div class="header-text-wrap">
                        <div class="header-inst-title">{{ $schoolName ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</div>
                        <div class="header-inst-sub">KABUPATEN TASIKMALAYA</div>
                    </div>

                    <!-- Logo Sekolah (Kanan) -->
                    <div class="header-logo-wrap" title="Logo Sekolah">
                        @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                            <img src="{{ asset($appLogo) }}" alt="Logo Sekolah">
                        @elseif(file_exists(public_path('images/logo-sekolah.jpeg')))
                            <img src="{{ asset('images/logo-sekolah.jpeg') }}" alt="Logo Sekolah">
                        @else
                            <div class="header-logo-fallback">
                                {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Title Ribbon Bar -->
                <div class="card-title-bar">
                    <span class="card-title-text">KARTU ABSENSI DIGITAL SISWA</span>
                </div>

                <!-- Student Identity Section (Besar & Presisi) -->
                <div class="student-block">
                    <div class="student-name-text" title="{{ $student->name }}">{{ $student->name }}</div>
                    
                    <!-- 2-Column Meta Info Grid -->
                    <div class="meta-grid">
                        <div class="meta-box meta-box-nisn">
                            <span class="meta-box-label">NISN</span>
                            <span class="meta-box-value font-mono-num">{{ $student->nisn }}</span>
                        </div>
                        <div class="meta-box meta-box-class">
                            <span class="meta-box-label">KELAS</span>
                            <span class="meta-box-value">{{ $student->classRoom->name ?? $class->name ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- GIANT QR CODE SECTION (144px × 144px) -->
                <div class="qr-section">
                    <div class="qr-frame">
                        <span class="qr-corner corner-tl"></span>
                        <span class="qr-corner corner-tr"></span>
                        <span class="qr-corner corner-bl"></span>
                        <span class="qr-corner corner-br"></span>
                        {!! QrCode::size(144)->margin(0)->generate($student->nisn) !!}
                    </div>
                    <div class="qr-caption-bar">
                        <span class="caption-hairline"></span>
                        <span class="caption-text">SCAN UNTUK PRESENSI</span>
                        <span class="caption-hairline"></span>
                    </div>
                </div>

                <!-- Card Footer (Clean Modern, Tanpa Badge Aktif) -->
                <div class="card-footer">
                    <div class="footer-left">
                        <span class="footer-ta">TA {{ $class->academicYear->name ?? '2026/2027' }}</span>
                    </div>
                    <div class="footer-right">
                        <span class="footer-brand">{{ $appName ?? 'N-Presence' }}</span>
                    </div>
                </div>

                <!-- Bottom Accent Strip -->
                <div class="card-bottom-bar"></div>

            </div>
        </div>
        @empty
            <div class="empty-state no-print">
                Tidak ada data siswa aktif di kelas ini untuk dicetak.
            </div>
        @endforelse
    </div>

</body>
</html>
