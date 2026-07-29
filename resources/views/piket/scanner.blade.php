@extends('layouts.piket')

@section('title', 'Scanner Kehadiran Ultra-Fast')

@section('content')
<style>
    #reader { 
        width: 100% !important; 
        overflow: hidden; 
        border-radius: 1.5rem; 
        background-color: #020617; 
        position: relative;
    }
    #reader video { 
        object-fit: cover !important; 
        width: 100% !important; 
        height: auto !important; 
        min-height: 300px; 
        border-radius: 1.5rem;
        transform: none !important; 
    }
    #reader video.scan-mode-out {
        box-shadow: inset 0 0 30px rgba(168, 85, 247, 0.2);
    }
</style>

<div class="max-w-md mx-auto space-y-4">

    <!-- Mode Indicator Badge -->
    <div id="mode-badge" class="flex items-center justify-center gap-2 mb-1">
        <span id="mode-badge-dot" class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981] animate-pulse"></span>
        <span id="mode-badge-text" class="text-xs font-bold uppercase tracking-widest text-emerald-400">Mode Masuk Pagi</span>
    </div>

    <!-- Camera Viewport Container -->
    <div id="camera-container" class="relative bg-slate-950 rounded-3xl overflow-hidden shadow-2xl border-2 border-emerald-500/40 flex items-center justify-center transition-all duration-500 min-h-[300px]">
        <!-- Scanner Target Overlay Frame -->
        <div id="scan-overlay" class="absolute inset-0 border-2 border-emerald-400/40 rounded-3xl pointer-events-none z-10 transition-all duration-500"></div>
        <div id="scan-line" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4/5 h-0.5 bg-emerald-400/90 shadow-[0_0_12px_#10b981] animate-pulse z-10 transition-all duration-500"></div>

        <!-- Html5Qrcode Scanner Element -->
        <div id="reader" class="w-full h-full"></div>
    </div>

    <!-- Mode Selector Buttons -->
    <div class="grid grid-cols-2 gap-3">
        <!-- Mode Masuk -->
        <button id="btn-mode-in" onclick="setMode('in')" 
            class="flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-[0_0_12px_rgba(59,130,246,0.15)] bg-blue-50 border-blue-400 text-blue-800 ring-1 ring-blue-400/50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
            </svg>
            <span class="text-xs font-bold uppercase tracking-wider">Mode Masuk</span>
            <span class="text-[9px] text-blue-600/80 mt-0.5">Absensi Pagi Hari</span>
        </button>

        <!-- Mode Pulang -->
        <button id="btn-mode-out" onclick="setMode('out')" 
            class="flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-sm bg-slate-800/40 border-slate-700/50 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-1 text-slate-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
            </svg>
            <span class="text-xs font-bold uppercase tracking-wider">Mode Pulang</span>
            <span class="text-[9px] text-slate-500 mt-0.5">Absensi Siang Hari</span>
        </button>
    </div>

    <!-- Quick Tip Banner -->
    <div class="p-3 bg-slate-800/60 border border-slate-700/40 rounded-2xl text-center">
        <p class="text-[11px] text-slate-300 font-medium">⚡ Sensor Otomatis Aktif (30 FPS Hardware Accelerated)</p>
        <p class="text-[9px] text-slate-400 mt-0.5">Arahkan QR Code Kartu Siswa ke area kotak di atas</p>
    </div>
</div>

<!-- Floating Animated Notification Card -->
<div id="scan-toast" class="fixed bottom-20 inset-x-4 max-w-sm mx-auto z-50 transform translate-y-32 opacity-0 transition-all duration-300 ease-out pointer-events-none">
    <div id="toast-body" class="p-4 rounded-3xl shadow-2xl border">
        <div class="flex items-center space-x-3">
            <div id="toast-photo" class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 flex-shrink-0 border-2 border-white shadow-sm">
                <div id="toast-photo-initial" class="w-full h-full flex items-center justify-center text-slate-600 font-bold text-xl"></div>
                <img id="toast-photo-img" class="w-full h-full object-cover hidden">
            </div>
            <div class="flex-1 min-w-0">
                <h4 id="toast-student-name" class="text-sm font-bold truncate">Memuat...</h4>
                <p id="toast-student-nisn" class="text-[10px] font-mono mt-0.5">NISN: -</p>
                <p id="toast-student-class" class="text-[10px] mt-0.5">Kelas: -</p>
            </div>
            <div id="toast-icon-wrapper" class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0"></div>
        </div>
        <div id="toast-status-bar" class="mt-3 pt-3 border-t border-white/30 flex items-center justify-between">
            <p id="toast-status-msg" class="text-xs font-semibold">Status Kehadiran</p>
            <p id="toast-scan-time" class="text-[10px] font-mono opacity-80"></p>
        </div>
        <div id="toast-motivation-wrap" class="mt-2.5 pt-2.5 border-t border-white/20 hidden">
            <div class="px-3 py-2 rounded-xl">
                <p id="toast-motivation-text" class="text-xs italic leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>

<!-- HTML5-QRCode Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let currentMode = 'in';
    let html5QrcodeScanner = null;
    let isProcessing = false;
    let lastScannedCode = '';
    let lastScannedTime = 0;

    // Direct URL Parameter Detection for Mode (?mode=out)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('mode') === 'out') {
        currentMode = 'out';
    }

    // High performance Web Audio API Beep Generator
    function playBeep(success = true) {
        try {
            if (navigator.vibrate) {
                navigator.vibrate(success ? [100] : [200, 100, 200]);
            }

            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            if (success) {
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(880, audioCtx.currentTime);
                gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime);
                oscillator.start();
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.15);
                oscillator.stop(audioCtx.currentTime + 0.15);
            } else {
                oscillator.type = 'sawtooth';
                oscillator.frequency.setValueAtTime(160, audioCtx.currentTime);
                gainNode.gain.setValueAtTime(0.25, audioCtx.currentTime);
                oscillator.start();
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                oscillator.stop(audioCtx.currentTime + 0.3);
            }
        } catch (e) {
            console.error('AudioContext Error:', e);
        }
    }

    function setMode(mode) {
        if (isProcessing) return;
        currentMode = mode;
        
        const btnIn = document.getElementById('btn-mode-in');
        const btnOut = document.getElementById('btn-mode-out');
        const camera = document.getElementById('camera-container');
        const overlay = document.getElementById('scan-overlay');
        const scanLine = document.getElementById('scan-line');
        const badgeDot = document.getElementById('mode-badge-dot');
        const badgeText = document.getElementById('mode-badge-text');

        if (mode === 'in') {
            btnIn.className = "flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-[0_0_12px_rgba(59,130,246,0.15)] bg-blue-50 border-blue-400 text-blue-800 ring-1 ring-blue-400/50";
            btnIn.querySelector('svg').className = "w-6 h-6 mb-1 text-blue-600";
            
            btnOut.className = "flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-sm bg-slate-800/40 border-slate-700/50 text-slate-400";
            btnOut.querySelector('svg').className = "w-6 h-6 mb-1 text-slate-500";

            camera.className = "relative bg-slate-950 rounded-3xl overflow-hidden shadow-2xl border-2 border-emerald-500/40 flex items-center justify-center transition-all duration-500 min-h-[300px]";
            overlay.className = "absolute inset-0 border-2 border-emerald-400/40 rounded-3xl pointer-events-none z-10 transition-all duration-500";
            scanLine.className = "absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4/5 h-0.5 bg-emerald-400/90 shadow-[0_0_12px_#10b981] animate-pulse z-10 transition-all duration-500";

            badgeDot.className = "w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981] animate-pulse";
            badgeText.className = "text-xs font-bold uppercase tracking-widest text-emerald-400";
            badgeText.innerText = 'Mode Masuk Pagi';
        } else {
            btnIn.className = "flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-sm bg-slate-800/40 border-slate-700/50 text-slate-400";
            btnIn.querySelector('svg').className = "w-6 h-6 mb-1 text-slate-500";

            btnOut.className = "flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 transition-all duration-300 shadow-[0_0_12px_rgba(168,85,247,0.15)] bg-purple-50 border-purple-400 text-purple-800 ring-1 ring-purple-400/50";
            btnOut.querySelector('svg').className = "w-6 h-6 mb-1 text-purple-600";

            camera.className = "relative bg-slate-950 rounded-3xl overflow-hidden shadow-2xl border-2 border-purple-500/40 flex items-center justify-center transition-all duration-500 min-h-[300px]";
            overlay.className = "absolute inset-0 border-2 border-purple-400/40 rounded-3xl pointer-events-none z-10 transition-all duration-500";
            scanLine.className = "absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4/5 h-0.5 bg-purple-400/90 shadow-[0_0_12px_#a855f7] animate-pulse z-10 transition-all duration-500";

            badgeDot.className = "w-2.5 h-2.5 rounded-full bg-purple-500 shadow-[0_0_8px_#a855f7] animate-pulse";
            badgeText.className = "text-xs font-bold uppercase tracking-widest text-purple-400";
            badgeText.innerText = 'Mode Pulang Siang';
        }
    }

    function showToast(type, data) {
        const toast = document.getElementById('scan-toast');
        const body = document.getElementById('toast-body');
        const iconWrapper = document.getElementById('toast-icon-wrapper');

        document.getElementById('toast-student-name').innerText = data.student_name || data.name || '-';
        document.getElementById('toast-student-nisn').innerText = `NISN: ${data.student_nisn || data.nisn || '-'}`;
        document.getElementById('toast-student-class').innerText = `Kelas: ${data.student_class || '-'}`;
        document.getElementById('toast-status-msg').innerText = data.message || '';
        document.getElementById('toast-scan-time').innerText = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        const motWrap = document.getElementById('toast-motivation-wrap');
        const motText = document.getElementById('toast-motivation-text');
        if (data.motivation_text) {
            motText.innerText = data.motivation_text;
            motWrap.classList.remove('hidden');
        } else {
            motWrap.classList.add('hidden');
        }

        const photoDiv = document.getElementById('toast-photo');
        const initialDiv = document.getElementById('toast-photo-initial');
        const imgEl = document.getElementById('toast-photo-img');

        if (data.student_photo) {
            imgEl.src = data.student_photo;
            imgEl.onerror = function() {
                imgEl.classList.add('hidden');
                initialDiv.classList.remove('hidden');
                const name = data.student_name || '';
                initialDiv.innerText = name.charAt(0).toUpperCase() || '?';
            };
            imgEl.classList.remove('hidden');
            initialDiv.classList.add('hidden');
        } else {
            imgEl.classList.add('hidden');
            initialDiv.classList.remove('hidden');
            const name = data.student_name || '';
            initialDiv.innerText = name.charAt(0).toUpperCase() || '?';
        }

        body.className = "p-4 rounded-3xl shadow-2xl border transition-all duration-300";

        const isPulang = currentMode === 'out' && type === 'success';

        let iconSvg = '';
        if (isPulang) {
            body.classList.add('bg-purple-50', 'border-purple-200', 'text-purple-900');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-purple-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-purple-100 text-purple-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>`;
            playBeep(true);
        } else if (type === 'success') {
            body.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-900');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-emerald-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>`;
            playBeep(true);
        } else if (type === 'warning') {
            body.classList.add('bg-orange-50', 'border-orange-200', 'text-orange-950');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-orange-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-orange-100 text-orange-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>`;
            playBeep(true);
        } else {
            body.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-900');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-rose-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-rose-100 text-rose-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>`;
            playBeep(false);
        }

        iconWrapper.innerHTML = iconSvg;

        toast.classList.remove('translate-y-32', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-32', 'opacity-0');
            isProcessing = false;
        }, 3000);
    }

    function onScanSuccess(decodedText, decodedResult) {
        const now = Date.now();
        // Prevent duplicate spam scanning within 1.5s for same QR code
        if (isProcessing || (decodedText === lastScannedCode && (now - lastScannedTime) < 1500)) {
            return;
        }

        isProcessing = true;
        lastScannedCode = decodedText;
        lastScannedTime = now;

        const endpoint = currentMode === 'in' ? '/api/attendance/scan-in' : '/api/attendance/scan-out';

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nisn: decodedText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (currentMode === 'out') {
                    showToast('success', { ...data, message: '🏡 Scan Pulang Berhasil' });
                } else if (data.attendance_status === 'Terlambat') {
                    showToast('warning', { ...data, message: `⚠️ Terlambat: ${data.late_duration} Menit` });
                } else {
                    showToast('success', { ...data, message: '✅ Scan Masuk Berhasil' });
                }
            } else {
                showToast('error', {
                    student_name: 'Gagal Absen',
                    student_nisn: decodedText,
                    student_class: '-',
                    message: data.message || 'Siswa tidak terdaftar.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', {
                student_name: 'Sistem Bermasalah',
                student_nisn: decodedText,
                student_class: '-',
                message: 'Gagal terhubung ke server lokal.'
            });
        });
    }

    // Ultra-Fast Hardware-Accelerated Scanner Initialization
    window.addEventListener('DOMContentLoaded', () => {
        if (currentMode === 'out') setMode('out');

        html5QrcodeScanner = new Html5Qrcode("reader", {
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true // Fast native OS hardware detection
            }
        });

        const config = {
            fps: 30, // Maximum 30 FPS for instant reaction speed
            qrbox: function(viewfinderWidth, viewfinderHeight) {
                const minDimension = Math.min(viewfinderWidth, viewfinderHeight);
                return {
                    width: Math.floor(minDimension * 0.75),
                    height: Math.floor(minDimension * 0.75)
                };
            },
            aspectRatio: 1.0,
            formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ]
        };

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            config,
            onScanSuccess
        ).catch(err => {
            console.error("Gagal menyalakan kamera:", err);
            document.getElementById('reader').innerHTML = `
                <div class="p-6 text-center text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2 text-slate-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    </svg>
                    <p class="text-xs font-semibold text-white">Kamera Tidak Dapat Diakses</p>
                    <p class="text-[10px] mt-1 text-slate-400">Berikan izin akses kamera pada browser Anda.</p>
                </div>
            `;
        });
    });
</script>
@endsection
