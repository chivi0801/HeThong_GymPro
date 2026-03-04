<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymPro - Điểm danh sinh trắc học</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0b1120; /* Nền tối xanh đen */
            color: #ffffff;
        }

        /* Hiệu ứng thanh quét chạy lên xuống */
        .scanner-container {
            position: relative;
        }
        
        .scanner-line {
            position: absolute;
            left: 0;
            width: 100%;
            height: 3px;
            background: #22d3ee;
            box-shadow: 0 0 15px 5px rgba(34, 211, 238, 0.4);
            animation: scan-animation 2.5s ease-in-out infinite;
        }

        @keyframes scan-animation {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            50% { top: calc(100% - 3px); opacity: 1; }
            90% { opacity: 1; }
            100% { top: 0%; opacity: 0; }
        }

        /* Khung bo góc đặc biệt (4 góc L) */
        .face-frame {
            position: relative;
            border-radius: 40px;
            overflow: hidden; /* Cắt thanh quét không bị lem ra ngoài góc bo */
        }
        
        .face-frame::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 3px solid #22d3ee;
            border-radius: 40px;
            /* Dùng mask để giữ lại 4 góc (mỗi góc chiếm 25% chiều dài/rộng), ẩn đi phần giữa */
            -webkit-mask: 
                linear-gradient(#fff, #fff) top left / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) top right / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) bottom left / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) bottom right / 25% 25% no-repeat;
            mask: 
                linear-gradient(#fff, #fff) top left / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) top right / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) bottom left / 25% 25% no-repeat,
                linear-gradient(#fff, #fff) bottom right / 25% 25% no-repeat;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <header class="flex items-center justify-between p-4 border-b border-slate-800 bg-[#0b1120] sticky top-0 z-50">
        <div class="flex items-center gap-4">

            <a href="TongQuan.php" class="w-10 h-10 rounded-full border border-slate-700 flex items-center justify-center hover:bg-slate-800 transition text-slate-300">
                <i class="fas fa-arrow-left"></i>
            </a>

            <div class="hidden md:block font-bold text-xl tracking-wide"></div>
        </div>

        <div class="flex-1 max-w-xl mx-4 relative hidden md:block">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Tìm kiếm hội viên hoặc bản ghi..." class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl pl-12 pr-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 text-white placeholder-slate-400 transition">
        </div>

        <div class="flex items-center gap-4 text-slate-300">
            <button class="w-10 h-10 rounded-full hover:bg-slate-800 transition flex items-center justify-center"><i class="far fa-bell text-lg"></i></button>
            <button class="w-10 h-10 rounded-full hover:bg-slate-800 transition flex items-center justify-center"><i class="fas fa-cog text-lg"></i></button>
            
            <button class="px-4 py-2 bg-slate-800 border border-slate-700/50 rounded-xl text-sm font-medium flex items-center gap-2 hover:bg-slate-700 transition hidden lg:flex">
                <i class="fas fa-expand text-slate-400"></i> Quét khuôn mặt
            </button>
            <button class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 rounded-xl text-sm font-semibold flex items-center gap-2 transition text-white shadow-lg shadow-blue-500/20">
                <i class="fas fa-user-plus"></i> Đăng ký mới
            </button>
        </div>
    </header>

    <main class="flex-1 p-4 md:p-8 max-w-7xl mx-auto w-full">
        
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-[10px] font-bold tracking-wider bg-blue-500/20 border border-blue-500/30 text-blue-400 px-2 py-0.5 rounded uppercase">Hệ thống AI</span>
                <span class="text-[10px] font-bold tracking-wider text-cyan-400 flex items-center gap-1.5 uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                    Đang hoạt động
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2">Điểm danh sinh trắc học</h1>
            <p class="text-slate-400 text-sm">Nhận diện khuôn mặt thời gian thực để ra vào phòng tập</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 flex flex-col gap-8">
                
                <div class="relative w-full aspect-video bg-slate-900 rounded-2xl overflow-hidden border border-slate-700/50 shadow-xl">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop" class="w-full h-full object-cover opacity-50" alt="Gym Camera View">
                    
                    <div class="absolute top-5 left-5 bg-black/70 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1.5 rounded-full flex items-center gap-2 border border-slate-700/50">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        LIVE FEED - CAM 01
                    </div>

                    <div class="absolute bottom-16 left-5 bg-black/70 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1.5 rounded-full flex items-center gap-2 border border-slate-700/50">
                        <i class="fas fa-eye text-cyan-400"></i> FPS: 60
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-64 h-64 md:w-80 md:h-80 face-frame bg-cyan-500/5 backdrop-blur-[1px]">
                            <div class="scanner-line"></div>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full px-5 py-4 bg-gradient-to-t from-[#0b1120] via-[#0b1120]/80 to-transparent flex flex-wrap justify-between items-center text-sm">
                        <div class="flex gap-6 items-center">
                            <span class="text-slate-300 flex items-center gap-2"><i class="fas fa-user text-slate-400"></i> Nhận diện: <span class="text-cyan-400 font-semibold">Bật</span></span>
                            <span class="text-slate-300 flex items-center gap-2"><i class="fas fa-bolt text-slate-400"></i> Độ trễ: 18ms</span>
                        </div>
                        <span class="text-slate-400 text-xs hidden sm:block">Vui lòng hướng mặt về phía camera để quét tự động</span>
                    </div>
                </div>

                <div class="bg-slate-800/30 border border-slate-700/50 rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-semibold text-lg">Check-in gần đây</h3>
                        <a href="#" class="text-blue-400 text-sm hover:text-blue-300 transition">Xem tất cả</a>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-slate-800/50 rounded-xl border border-slate-700/30 hover:bg-slate-800 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-orange-200/20 border border-orange-500/20 flex items-center justify-center text-orange-300 font-bold text-lg">B</div>
                                <div>
                                    <h4 class="font-semibold">Nguyễn Văn B</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">Gói Standard • Check-in khuôn mặt</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-1">2 phút trước</p>
                                <p class="text-[10px] font-bold text-blue-400 tracking-wider bg-blue-500/10 px-2 py-0.5 rounded">THÀNH CÔNG</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-800/50 rounded-xl border border-slate-700/30 hover:bg-slate-800 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-orange-200/20 border border-orange-500/20 flex items-center justify-center text-orange-300 font-bold text-lg">C</div>
                                <div>
                                    <h4 class="font-semibold">Bùi Thị C</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">Gói Premium • Check-in khuôn mặt</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-1">15 phút trước</p>
                                <p class="text-[10px] font-bold text-blue-400 tracking-wider bg-blue-500/10 px-2 py-0.5 rounded">THÀNH CÔNG</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/30 border border-slate-700/50 rounded-3xl p-6 lg:p-8 flex flex-col shadow-xl">
                <div class="flex justify-between items-center mb-8 text-sm">
                    <span class="text-slate-400 font-medium tracking-widest text-[11px] uppercase">Thông tin nhận diện</span>
                    <span class="text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2.5 py-1 rounded-full flex items-center gap-1.5 text-xs font-semibold">
                        <i class="fas fa-check-circle"></i> ĐÃ XÁC THỰC
                    </span>
                </div>

                <div class="flex flex-col items-center mb-8">
                    <div class="relative mb-5">
                        <div class="w-32 h-32 rounded-full border-[3px] border-blue-500 p-1">
                            <img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?q=80&w=256&auto=format&fit=crop" class="w-full h-full object-cover rounded-full" alt="User">
                        </div>
                        <div class="absolute bottom-0 right-2 w-8 h-8 bg-purple-500 rounded-full border-2 border-[#0b1120] flex items-center justify-center shadow-[0_0_15px_rgba(168,85,247,0.8)]">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold mb-1">Nguyen Van A</h2>
                    <p class="text-slate-400 text-xs font-medium tracking-wide">MÃ THÀNH VIÊN: <span class="text-slate-300">#GYM-99812</span></p>
                </div>

                <div class="space-y-4 mb-8 flex-1">
                    <div class="flex items-center justify-between p-4 bg-slate-900/60 rounded-2xl border border-slate-700/50">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-purple-400"><i class="fas fa-star"></i></div>
                            <span class="text-sm font-medium">Gói tập: Nâng cao</span>
                        </div>
                        <span class="font-semibold text-white">Nâng cao</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-slate-900/60 rounded-2xl border border-orange-500/40 shadow-[0_0_15px_rgba(249,115,22,0.1)]">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-9 h-9 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-400"><i class="far fa-calendar-alt"></i></div>
                            <span class="text-sm font-medium">Ngày còn lại</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-orange-400 block text-lg leading-tight">5 Ngày</span>
                            <span class="text-[9px] font-bold tracking-wider text-orange-400/80">GIA HẠN NGAY</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-900/60 rounded-2xl border border-slate-700/50">
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-slate-400"><i class="fas fa-history"></i></div>
                            <span class="text-sm font-medium">Lần cuối</span>
                        </div>
                        <span class="font-semibold text-white text-sm">Hôm qua, 17:30</span>
                    </div>
                </div>

                <div class="space-y-3 mt-auto">
                    <button class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold rounded-2xl shadow-lg shadow-purple-500/25 transition flex items-center justify-center gap-2">
                        XÁC NHẬN VÀO CỔNG <i class="fas fa-sign-in-alt ml-1"></i>
                    </button>
                    <button class="w-full py-3.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 font-medium rounded-2xl transition text-sm">
                        Không phải bạn? Quét lại
                    </button>
                </div>
            </div>
            
        </div>
    </main>


   
</body>
</html>


