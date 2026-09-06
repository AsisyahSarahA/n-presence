@extends('layouts.piket')

@section('title', 'Scanner Kehadiran Ultra-Fast')

@section('content')
<style>
    #reader {
        width: 100% !important;
        height: 100% !important;
        overflow: hidden;
        border-radius: 1.5rem;
        background-color: #000000;
        position: relative;
    }
    #reader video {
        object-fit: cover !important;
        width: 100% !important;
        height: 100% !important;
        min-height: 280px;
        border-radius: 1.5rem;
        transform: none !important;
    }
    #reader video.scan-mode-out {
        box-shadow: inset 0 0 30px rgba(168, 85, 247, 0.2);
    }
    @keyframes laser-scan {
        0% { top: 18%; opacity: 0.7; }
        50% { top: 82%; opacity: 1; }
        100% { top: 18%; opacity: 0.7; }
    }
    .animate-laser {
        animation: laser-scan 2.2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<div class="max-w-md mx-auto space-y-4">

    <!-- Mode Indicator Badge (Tactile Beveled Pill) -->
    <div id="mode-badge" class="flex items-center justify-center gap-2 mb-1">
        <span class="skeuo-badge px-3 py-1 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-black shadow-sm flex items-center gap-2">
            <span id="mode-badge-dot" class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981] animate-pulse"></span>
            <span id="mode-badge-text" class="uppercase tracking-widest text-emerald-600 dark:text-emerald-400 font-black">Mode Masuk Pagi</span>
        </span>
    </div>

    <!-- Responsive Camera Viewport Container (Hardware Lens Bezel) -->
    <div id="camera-container" class="relative bg-black rounded-3xl overflow-hidden shadow-[inset_0_4px_12px_rgba(0,0,0,0.9),0_12px_32px_rgba(15,23,42,0.4)] border-4 border-slate-700/80 dark:border-slate-800 flex items-center justify-center transition-all duration-500 w-full h-[360px] sm:h-[380px] md:h-[400px] max-h-[60vh]">
        <!-- Top Bezel Specular Highlight Line -->
        <div class="absolute top-0 inset-x-0 h-[1px] bg-gradient-to-r from-transparent via-white/40 to-transparent pointer-events-none z-30"></div>

        <!-- Scanner Target Overlay Frame -->
        <div id="scan-overlay" class="absolute inset-0 border-2 border-emerald-400/50 rounded-3xl pointer-events-none z-10 transition-all duration-500"></div>
        <div id="scan-line" class="absolute left-1/2 -translate-x-1/2 w-3/4 h-0.5 bg-emerald-400 shadow-[0_0_12px_#10b981] animate-laser z-10 transition-all duration-500"></div>

        <!-- Skeleton Loading Kamera -->
        <div id="scanner-skeleton" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-950 z-20 transition-opacity duration-300">
            <div class="w-12 h-12 rounded-full border-4 border-slate-800 border-t-emerald-500 animate-spin mb-4"></div>
            <p class="text-xs text-slate-300 animate-pulse font-bold">Menghubungkan ke Kamera...</p>
        </div>

        <!-- Html5Qrcode Scanner Element -->
        <div id="reader" class="w-full h-full"></div>
    </div>

    <!-- Mode Selector Buttons (Tactile 3D Buttons) -->
    <div class="grid grid-cols-2 gap-3.5">
        <!-- Mode Masuk -->
        <button id="btn-mode-in" onclick="setMode('in')" type="button"
            class="flex flex-col items-center justify-center p-4 rounded-2xl border-t border-t-white/30 border-b-[3px] border-b-blue-900 bg-gradient-to-b from-blue-500 to-blue-700 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_4px_10px_rgba(37,99,235,0.25)] transition-all duration-200 active:translate-y-[2px] active:border-b-[1px] select-none">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mb-1.5 shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
            </div>
            <span class="text-xs font-black uppercase tracking-wider">Mode Masuk</span>
            <span class="text-[10px] text-blue-100 font-semibold mt-0.5">Absensi Pagi Hari</span>
        </button>

        <!-- Mode Pulang -->
        <button id="btn-mode-out" onclick="setMode('out')" type="button"
            class="flex flex-col items-center justify-center p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-gradient-to-b from-white to-slate-100 dark:from-slate-800 dark:to-slate-900 text-slate-600 dark:text-slate-300 shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.05),0_3px_0_#cbd5e1] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.08),0_3px_0_#0f172a] transition-all duration-200 active:translate-y-[2px] hover:bg-slate-50 select-none">
            <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center mb-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-slate-500 dark:text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
            </div>
            <span class="text-xs font-black uppercase tracking-wider">Mode Pulang</span>
            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold mt-0.5">Mulai {{ $timeOutStart ?? '13:00' }} WIB</span>
        </button>
    </div>

    <!-- Quick Tip Banner (Tactile Card) -->
    <div id="tip-banner" class="skeuo-card p-3.5 text-center">
        <p class="text-xs text-slate-800 dark:text-slate-200 font-black flex items-center justify-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
            </svg>
            <span>Sensor Otomatis Aktif (Scan Instan)</span>
        </p>
        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 font-medium">Arahkan QR Code Kartu Siswa ke area kamera di atas</p>
    </div>
</div>

<!-- Floating Animated Notification Card -->
<div id="scan-toast" class="fixed bottom-20 inset-x-4 max-w-sm mx-auto z-50 transform translate-y-32 opacity-0 transition-all duration-300 ease-out pointer-events-none">
    <div id="toast-body" class="p-4 rounded-3xl shadow-2xl border">
        <div class="flex items-center space-x-3">
            <div id="toast-photo" class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 flex-shrink-0 border-2 border-white shadow-sm flex items-center justify-center">
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
    let toastTimeout = null;

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

    // Suara / Audio Voice Synthesis (Indonesian)
    function speakText(text) {
        if (!text) return;
        try {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const cleanText = text.replace(/[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}]/gu, '');
                const utterance = new SpeechSynthesisUtterance(cleanText.trim());
                utterance.lang = 'id-ID';
                utterance.rate = 0.95;
                utterance.pitch = 1.0;
                window.speechSynthesis.speak(utterance);
            }
        } catch (e) {
            console.error('SpeechSynthesis Error:', e);
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
            btnIn.className = "flex flex-col items-center justify-center p-4 rounded-2xl border-t border-t-white/30 border-b-[3px] border-b-blue-900 bg-gradient-to-b from-blue-500 to-blue-700 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_4px_10px_rgba(37,99,235,0.25)] transition-all duration-200 active:translate-y-[2px] active:border-b-[1px] select-none";
            btnIn.querySelector('svg').className = "w-5 h-5 text-white";

            btnOut.className = "flex flex-col items-center justify-center p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-gradient-to-b from-white to-slate-100 dark:from-slate-800 dark:to-slate-900 text-slate-600 dark:text-slate-300 shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.05),0_3px_0_#cbd5e1] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.08),0_3px_0_#0f172a] transition-all duration-200 active:translate-y-[2px] hover:bg-slate-50 select-none";
            btnOut.querySelector('svg').className = "w-5 h-5 text-slate-500 dark:text-slate-400";

            camera.className = "relative bg-black rounded-3xl overflow-hidden shadow-[inset_0_4px_12px_rgba(0,0,0,0.9),0_12px_32px_rgba(15,23,42,0.4)] border-4 border-slate-700/80 dark:border-slate-800 flex items-center justify-center transition-all duration-500 w-full h-[360px] sm:h-[380px] md:h-[400px] max-h-[60vh]";
            overlay.className = "absolute inset-0 border-2 border-emerald-400/50 rounded-3xl pointer-events-none z-10 transition-all duration-500";
            scanLine.className = "absolute left-1/2 -translate-x-1/2 w-3/4 h-0.5 bg-emerald-400 shadow-[0_0_12px_#10b981] animate-laser z-10 transition-all duration-500";

            badgeDot.className = "w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981] animate-pulse";
            badgeText.className = "uppercase tracking-widest text-emerald-600 dark:text-emerald-400 font-black";
            badgeText.innerText = 'Mode Masuk Pagi';
        } else {
            btnIn.className = "flex flex-col items-center justify-center p-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-gradient-to-b from-white to-slate-100 dark:from-slate-800 dark:to-slate-900 text-slate-600 dark:text-slate-300 shadow-[inset_0_1px_0_#ffffff,0_2px_4px_rgba(0,0,0,0.05),0_3px_0_#cbd5e1] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.08),0_3px_0_#0f172a] transition-all duration-200 active:translate-y-[2px] hover:bg-slate-50 select-none";
            btnIn.querySelector('svg').className = "w-5 h-5 text-slate-500 dark:text-slate-400";

            btnOut.className = "flex flex-col items-center justify-center p-4 rounded-2xl border-t border-t-white/30 border-b-[3px] border-b-purple-950 bg-gradient-to-b from-purple-600 to-purple-800 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.35),0_4px_10px_rgba(168,85,247,0.25)] transition-all duration-200 active:translate-y-[2px] active:border-b-[1px] select-none";
            btnOut.querySelector('svg').className = "w-5 h-5 text-white";

            camera.className = "relative bg-black rounded-3xl overflow-hidden shadow-[inset_0_4px_12px_rgba(0,0,0,0.9),0_12px_32px_rgba(15,23,42,0.4)] border-4 border-purple-900/80 dark:border-purple-950 flex items-center justify-center transition-all duration-500 w-full h-[360px] sm:h-[380px] md:h-[400px] max-h-[60vh]";
            overlay.className = "absolute inset-0 border-2 border-purple-400/50 rounded-3xl pointer-events-none z-10 transition-all duration-500";
            scanLine.className = "absolute left-1/2 -translate-x-1/2 w-3/4 h-0.5 bg-purple-400 shadow-[0_0_12px_#a855f7] animate-laser z-10 transition-all duration-500";

            badgeDot.className = "w-2.5 h-2.5 rounded-full bg-purple-500 shadow-[0_0_8px_#a855f7] animate-pulse";
            badgeText.className = "uppercase tracking-widest text-purple-600 dark:text-purple-400 font-black";
            badgeText.innerText = 'Mode Pulang (Mulai {{ $timeOutStart ?? "13:00" }} WIB)';
        }
    }

    function showToastLoading() {
        if (toastTimeout) clearTimeout(toastTimeout);
        const toast = document.getElementById('scan-toast');
        const body = document.getElementById('toast-body');

        body.className = "p-4 rounded-3xl shadow-2xl border bg-slate-800 border-slate-700 text-slate-100 transition-all duration-300";

        document.getElementById('toast-student-name').innerHTML = `<div class="h-4 w-28 bg-slate-700 rounded animate-pulse"></div>`;
        document.getElementById('toast-student-nisn').innerHTML = `<div class="h-3 w-20 bg-slate-700/80 rounded animate-pulse mt-1"></div>`;
        document.getElementById('toast-student-class').innerHTML = `<div class="h-3 w-16 bg-slate-700/80 rounded animate-pulse mt-1"></div>`;
        document.getElementById('toast-status-msg').innerText = 'Memproses absensi...';
        document.getElementById('toast-scan-time').innerText = '';

        const photoDiv = document.getElementById('toast-photo');
        const initialDiv = document.getElementById('toast-photo-initial');
        const imgEl = document.getElementById('toast-photo-img');

        imgEl.classList.add('hidden');
        initialDiv.classList.remove('hidden');
        photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-slate-700 shadow-sm flex items-center justify-center";
        initialDiv.innerHTML = `<div class="w-8 h-8 rounded-full bg-slate-700 animate-pulse"></div>`;

        document.getElementById('toast-motivation-wrap').classList.add('hidden');

        toast.classList.remove('translate-y-32', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    }

    function showToast(type, data) {
        if (toastTimeout) clearTimeout(toastTimeout);
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
            body.classList.add('bg-sky-50', 'border-sky-200', 'text-sky-900');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-sky-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-sky-100 text-sky-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>`;
            playBeep(true);
        } else if (type === 'success') {
            body.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-900');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-emerald-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-emerald-100 text-emerald-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>`;
            playBeep(true);
        } else if (type === 'warning') {
            body.classList.add('bg-amber-50', 'border-amber-200', 'text-amber-950');
            photoDiv.className = "w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 border-amber-300 shadow-sm";
            iconWrapper.className = "w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 bg-amber-100 text-amber-600";
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>`;
            playBeep(false);
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

        toastTimeout = setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-32', 'opacity-0');
            isProcessing = false;
        }, 3500);
    }

    function onScanSuccess(decodedText, decodedResult) {
        const now = Date.now();
        // Prevent duplicate scan spamming within 1.5s for same QR code
        if (isProcessing || (decodedText === lastScannedCode && (now - lastScannedTime) < 1500)) {
            return;
        }

        isProcessing = true;
        lastScannedCode = decodedText;
        lastScannedTime = now;

        showToastLoading();

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
                    const timeOutLabel = data.time_out || new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    showToast('success', { ...data, message: `Berhasil Scan Pulang pada ${timeOutLabel}` });
                    speakText('Hari yang luar biasa, hati-hati di jalan');
                } else if (data.attendance_status === 'Terlambat') {
                    showToast('warning', { ...data, message: `Terlambat: ${data.late_duration} Menit` });
                    speakText('Selamat datang dan semangat belajar');
                } else {
                    showToast('success', { ...data, message: 'Scan Masuk Berhasil' });
                    speakText('Selamat datang dan semangat belajar');
                }
            } else if (data.status === 'warning') {
                showToast('warning', {
                    student_name: data.student_name || 'Peringatan Scan Pulang',
                    student_nisn: data.student_nisn || decodedText,
                    student_class: data.student_class || '-',
                    student_photo: data.student_photo || null,
                    message: data.message || 'Belum saatnya scan pulang!'
                });
                speakText(data.message || 'Belum saatnya scan pulang');
            } else {
                showToast('error', {
                    student_name: 'Gagal Absen',
                    student_nisn: decodedText,
                    student_class: '-',
                    message: data.message || 'Siswa tidak terdaftar atau belum scan masuk.'
                });
                speakText(data.message || 'Scan tidak dapat dilakukan');
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
            speakText('Gagal terhubung ke server');
        });
    }

    // Universal Multi-Device Camera Initializer
    async function initCamera() {
        const skeleton = document.getElementById('scanner-skeleton');
        if (skeleton) skeleton.classList.remove('hidden');

        try {
            // Request camera permission explicitly first to ensure prompt on HP & desktop browsers
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    stream.getTracks().forEach(track => track.stop());
                } catch (permErr) {
                    console.warn("Camera permission prompt error or dismissed:", permErr);
                }
            }

            if (html5QrcodeScanner) {
                try {
                    await html5QrcodeScanner.stop();
                } catch (e) {}
            }

            html5QrcodeScanner = new Html5Qrcode("reader");

            const isMobile = window.innerWidth < 640;
            const config = {
                fps: 20,
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    const minDim = Math.min(viewfinderWidth, viewfinderHeight);
                    const boxSize = Math.max(180, Math.min(Math.floor(minDim * 0.70), 260));
                    return { width: boxSize, height: boxSize };
                },
                aspectRatio: isMobile ? 0.75 : 1.333333,
                formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ]
            };

            // Attempt 1: Facing mode environment (Back camera on smartphones)
            try {
                await html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess);
                if (skeleton) skeleton.classList.add('hidden');
                return;
            } catch (envErr) {
                console.warn("FacingMode environment failed, trying user camera...", envErr);
            }

            // Attempt 2: Facing mode user (Webcam on laptop/desktop or front camera)
            try {
                await html5QrcodeScanner.start({ facingMode: "user" }, config, onScanSuccess);
                if (skeleton) skeleton.classList.add('hidden');
                return;
            } catch (userErr) {
                console.warn("FacingMode user failed, trying getCameras...", userErr);
            }

            // Attempt 3: Specific Camera Device ID fallback
            const devices = await Html5Qrcode.getCameras();
            if (devices && devices.length > 0) {
                const backCamera = devices.find(d => d.label.toLowerCase().includes('back') || d.label.toLowerCase().includes('rear')) || devices[devices.length - 1];
                await html5QrcodeScanner.start(backCamera.id, config, onScanSuccess);
                if (skeleton) skeleton.classList.add('hidden');
                return;
            }

            throw new Error("Kamera tidak ditemukan pada perangkat Anda.");

        } catch (err) {
            console.error("Gagal mengaktifkan kamera:", err);
            showCameraError(err ? (err.message || err.name || String(err)) : "Periksa izin kamera");
        }
    }

    function showCameraError(msg = "Berikan izin akses kamera pada browser Anda.") {
        const skeleton = document.getElementById('scanner-skeleton');
        if (skeleton) skeleton.classList.add('hidden');

        document.getElementById('reader').innerHTML = `
            <div class="p-6 text-center text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2 text-rose-400 animate-bounce">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                </svg>
                <p class="text-xs font-bold text-white">Kamera Tidak Dapat Diakses</p>
                <p class="text-[10px] mt-1 text-slate-400 max-w-xs mx-auto leading-relaxed">${msg}</p>
                <button onclick="initCamera()" class="mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg transition-all flex items-center justify-center space-x-1.5 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Izinkan & Coba Lagi</span>
                </button>
            </div>
        `;
    }

    // Auto-Start Camera on Load
    window.addEventListener('DOMContentLoaded', () => {
        if (currentMode === 'out') setMode('out');
        initCamera();
    });
</script>
@endsection
