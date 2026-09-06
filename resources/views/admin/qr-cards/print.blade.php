<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Absensi Siswa - {{ $class->name ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy-deep:   #0b1e36;
            --navy-mid:    #122e54;
            --navy-light:  #1e3a5f;
            --gold:        #f59e0b;
            --gold-light:  #fcd34d;
            --white:       #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #1a2a42;
            min-height: 100vh;
            padding: 24px;
            color: #e2e8f0;
        }

        /* ── Action Bar ── */
        .action-bar {
            max-width: 960px;
            margin: 0 auto 24px;
            background: #0f2035;
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 16px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
        }
        .action-bar-left { display: flex; align-items: center; gap: 12px; }
        .back-btn {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            color: #94a3b8;
            text-decoration: none;
            transition: all .2s;
        }
        .back-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .action-bar h1 { font-size: 14px; font-weight: 800; color: #fff; }
        .badge-formal {
            display: inline-block;
            font-size: 9px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase;
            padding: 2px 8px; border-radius: 999px;
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
            border: 1px solid rgba(245,158,11,0.30);
            margin-left: 8px;
        }
        .action-bar p { font-size: 11px; color: #64748b; margin-top: 2px; }
        .tips-text { font-size: 10px; color: #475569; }
        .btn-print {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #1e5fa8, #264b9c);
            color: #fff; font-size: 12px; font-weight: 700;
            padding: 9px 20px; border-radius: 12px; border: none; cursor: pointer;
            box-shadow: 0 4px 12px rgba(30,95,168,0.45), inset 0 1px 0 rgba(255,255,255,0.15);
            transition: all .2s;
        }
        .btn-print:hover { background: linear-gradient(135deg, #2571c4, #2d5ab5); transform: translateY(-1px); }
        .btn-print:active { transform: scale(0.97); }

        /* ── Cards Grid ── */
        .cards-grid {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        /* ── ID Card (Portrait 5.4cm × 8.56cm - Credit Card ratio) ── */
        .card-wrapper {
            padding: 3px;
            border-radius: 18px;
            border: 1.5px dashed rgba(148,163,184,0.30);
        }

        .id-card {
            width: 204px;   /* ~5.4cm at 96dpi */
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.35), 0 2px 8px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', sans-serif;
            position: relative;
        }

        /* ── Card Header ── */
        .card-header {
            background: linear-gradient(160deg, var(--navy-deep) 0%, var(--navy-mid) 60%, var(--navy-light) 100%);
            padding: 10px 10px 7px;
            text-align: center;
            position: relative;
            border-bottom: 2.5px solid var(--gold);
        }
        .card-header::before {
            content: '';
            position: absolute; inset-x: 0; top: 0; height: 2px;
            background: linear-gradient(90deg, transparent, rgba(253,211,77,0.7), transparent);
        }
        .card-header-inner {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            margin-bottom: 4px;
        }
        .school-logo-wrap {
            width: 28px; height: 28px; flex-shrink: 0;
            border-radius: 6px;
            overflow: hidden;
            background: rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .school-logo-wrap img {
            width: 100%; height: 100%; object-fit: contain;
        }
        .school-logo-initial {
            width: 28px; height: 28px; flex-shrink: 0;
            border-radius: 6px;
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--navy-deep);
            font-weight: 900; font-size: 13px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .school-name {
            font-size: 7.5px; font-weight: 800; color: #fff;
            text-transform: uppercase; letter-spacing: .05em;
            line-height: 1.2;
            max-width: 130px;
            text-align: left;
        }
        .card-subtitle {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            font-size: 6px; font-weight: 700; color: var(--gold-light);
            letter-spacing: .12em; text-transform: uppercase;
        }
        .card-subtitle-line {
            height: 1px; width: 16px;
            background: rgba(253,211,77,0.5);
        }

        /* ── Card Body ── */
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 10px 8px;
            background: #fff;
            position: relative;
            gap: 7px;
        }

        /* Security watermark */
        .card-body::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(30,58,95,0.04) 1px, transparent 0);
            background-size: 8px 8px;
            pointer-events: none;
        }

        /* ── Photo Section ── */
        .photo-section {
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            position: relative; z-index: 1;
        }
        .photo-ring {
            padding: 2px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #1e5fa8, var(--gold-light));
            box-shadow: 0 3px 10px rgba(0,0,0,0.18);
        }
        .photo-img {
            width: 52px; height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            display: block;
        }
        .photo-initial {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy-deep), var(--navy-light));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 900; font-size: 20px;
            border: 2px solid #fff;
        }
        .student-name {
            font-size: 9.5px; font-weight: 800;
            color: #0f172a;
            text-transform: uppercase; letter-spacing: .02em;
            text-align: center; line-height: 1.2;
            max-width: 180px;
        }
        .meta-pills {
            display: flex; gap: 4px; flex-wrap: wrap; justify-content: center;
        }
        .pill {
            font-size: 6.5px; font-weight: 700;
            padding: 2px 6px; border-radius: 5px;
        }
        .pill-gray {
            background: #f1f5f9; color: #334155;
            border: 1px solid #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
        }
        .pill-blue {
            background: #eff6ff; color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        /* ── Divider ── */
        .card-divider {
            width: 100%; height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            position: relative; z-index: 1;
        }

        /* ── QR Section ── */
        .qr-section {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            position: relative; z-index: 1;
        }
        .qr-frame {
            position: relative;
            padding: 6px;
            background: #fff;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.8);
        }
        /* Corner scanner brackets */
        .qr-frame::before, .qr-frame::after,
        .qr-corner-bl, .qr-corner-br {
            content: '';
            position: absolute;
            width: 10px; height: 10px;
            border-color: var(--gold);
            border-style: solid;
        }
        .qr-frame::before  { top: 2px;    left: 2px;    border-width: 2px 0 0 2px; border-radius: 3px 0 0 0; }
        .qr-frame::after   { top: 2px;    right: 2px;   border-width: 2px 2px 0 0; border-radius: 0 3px 0 0; }
        .qr-corner-bl      { bottom: 2px; left: 2px;    border-width: 0 0 2px 2px; border-radius: 0 0 0 3px; }
        .qr-corner-br      { bottom: 2px; right: 2px;   border-width: 0 2px 2px 0; border-radius: 0 0 3px 0; }
        .qr-frame svg, .qr-frame img { display: block; }
        .qr-label {
            font-size: 5.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: #94a3b8; text-align: center;
        }

        /* ── Card Footer ── */
        .card-footer {
            background: linear-gradient(160deg, var(--navy-deep) 0%, var(--navy-mid) 100%);
            border-top: 2.5px solid var(--gold);
            padding: 6px 10px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-footer-left {
            display: flex; align-items: center; gap: 4px;
        }
        .dot-green {
            width: 5px; height: 5px; border-radius: 50%;
            background: #34d399; box-shadow: 0 0 4px rgba(52,211,153,0.6);
        }
        .footer-ta {
            font-size: 6.5px; font-weight: 700; color: #94a3b8;
            font-family: 'JetBrains Mono', monospace;
        }
        .footer-brand {
            font-size: 7px; font-weight: 800; color: var(--gold-light);
            letter-spacing: .05em;
        }

        /* ── Empty State ── */
        .empty-state {
            width: 100%; text-align: center; padding: 48px 24px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; color: #64748b;
            font-size: 13px;
        }

        /* ── Print Styles ── */
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            .cards-grid { gap: 6mm !important; }
            .card-wrapper {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                border: 1px dashed #ccc !important;
            }
            .id-card {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Hidden during Print) -->
    <div class="action-bar no-print">
        <div class="action-bar-left">
            <a href="{{ route('admin.qr-cards.index') }}" class="back-btn" title="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
            </a>
            <div>
                <h1>
                    Pratinjau Cetak Kartu Absensi Siswa
                    <span class="badge-formal">Format Formal &amp; Presisi</span>
                </h1>
                <p>
                    {{ $students->count() === 1 ? 'Siswa: ' . $students->first()->name : 'Kelas: ' . $class->name . ' (' . $students->count() . ' siswa)' }}
                    — Siap Cetak A4 (3–4 Kolom per Halaman)
                </p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span class="tips-text">Tips: Gunakan kertas <strong>Glory Photo Paper / PVC</strong></span>
            <button onclick="window.print()" class="btn-print">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="15" height="15">
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

                <!-- HEADER: Navy + Gold official band -->
                <div class="card-header">
                    <div class="card-header-inner">
                        @if(!empty($appLogo) && file_exists(public_path($appLogo)))
                            <div class="school-logo-wrap">
                                <img src="{{ asset($appLogo) }}" alt="Logo Sekolah">
                            </div>
                        @else
                            <div class="school-logo-initial">
                                {{ strtoupper(substr($appName ?? 'N', 0, 1)) }}
                            </div>
                        @endif
                        <div class="school-name">{{ $schoolName ?? 'SMPN SATU ATAP 1 CIGALONTANG' }}</div>
                    </div>
                    <div class="card-subtitle">
                        <span class="card-subtitle-line"></span>
                        KARTU ABSENSI DIGITAL SISWA
                        <span class="card-subtitle-line"></span>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body">

                    <!-- Profile -->
                    <div class="photo-section">
                        <div class="photo-ring">
                            @if($student->photo_path)
                                <img src="{{ asset('storage/' . $student->photo_path) }}" alt="Foto" class="photo-img">
                            @else
                                <div class="photo-initial">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div class="student-name">{{ $student->name }}</div>
                        <div class="meta-pills">
                            <span class="pill pill-gray">NISN: {{ $student->nisn }}</span>
                            <span class="pill pill-blue">Kelas {{ $class->name }}</span>
                        </div>
                    </div>

                    <div class="card-divider"></div>

                    <!-- QR Code -->
                    <div class="qr-section">
                        <div class="qr-frame">
                            <span class="qr-corner-bl"></span>
                            <span class="qr-corner-br"></span>
                            {!! QrCode::size(100)->generate($student->nisn) !!}
                        </div>
                        <p class="qr-label">&#9204; Scan untuk Presensi</p>
                    </div>

                </div>

                <!-- FOOTER: Formal Navy bar -->
                <div class="card-footer">
                    <div class="card-footer-left">
                        <span class="dot-green"></span>
                        <span class="footer-ta">TA {{ $class->academicYear->name ?? '2026/2027' }}</span>
                    </div>
                    <span class="footer-brand">{{ $appName ?? 'N-Presence' }}</span>
                </div>

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
