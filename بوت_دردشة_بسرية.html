<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واجهة مستخدم البوت</title>
    <!-- تضمين Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- تضمين Telegram Web Apps JS API -->
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--tg-theme-bg-color);
            color: var(--tg-theme-text-color);
        }
        .container {
            background-color: var(--tg-theme-secondary-bg-color);
            border-color: var(--tg-theme-link-color);
        }
    </style>
</head>
<body class="p-4 flex flex-col items-center justify-center min-h-screen transition-colors duration-300">

    <div class="container mx-auto p-6 rounded-lg shadow-xl max-w-sm w-full border-2">
        <h1 class="text-2xl font-bold mb-2 text-center">غرفة الدردشة بسرية</h1>
        <p class="text-sm text-center mb-6 opacity-80">استخدم الأزرار أدناه للتحكم في الغرفة مباشرة .</p>
        
        <div class="space-y-4">
            <button id="startButton" data-command="/start" class="w-full py-3 px-6 rounded-full text-white font-semibold shadow-lg transition-transform transform hover:scale-105 active:scale-95 duration-200" style="background-color: #3b82f6;">
                بدء المحادثة
            </button>
            <button id="nextButton" data-command="/next" class="w-full py-3 px-6 rounded-full text-white font-semibold shadow-lg transition-transform transform hover:scale-105 active:scale-95 duration-200" style="background-color: #f97316;">
                شريك جديد
            </button>
            <button id="stopButton" data-command="/stop" class="w-full py-3 px-6 rounded-full text-white font-semibold shadow-lg transition-transform transform hover:scale-105 active:scale-95 duration-200" style="background-color: #ef4444;">
                إيقاف المحادثة
            </button>
        </div>

        <hr class="my-6 border-t-2 opacity-10">

        <p id="userIdDisplay" class="text-center text-sm opacity-60"></p>
    </div>

    <script>
        window.onload = function() {
            // تحقق مما إذا كانت واجهة برمجة تطبيقات الويب من تيليجرام متاحة
            if (window.Telegram && window.Telegram.WebApp) {
                // إخبار تيليجرام أن التطبيق جاهز
                Telegram.WebApp.ready();
                
                // تحديث سمات الألوان وفقًا لموضوع تيليجرام
                document.body.style.backgroundColor = Telegram.WebApp.themeParams.bg_color;
                
                // عرض هوية المستخدم لأغراض الاختبار
                const userId = Telegram.WebApp.initDataUnsafe.user ? Telegram.WebApp.initDataUnsafe.user.id : "غير متاح";
                document.getElementById('userIdDisplay').textContent = `معرف المستخدم (للاختبار): ${userId}`;

                // إضافة مستمعي الأحداث للأزرار
                const buttons = document.querySelectorAll('button');
                buttons.forEach(button => {
                    button.addEventListener('click', () => {
                        const command = button.getAttribute('data-command');
                        if (command) {
                            // إرسال الأمر إلى البوت
                            Telegram.WebApp.sendData(command);
                            // إغلاق تطبيق الويب
                            Telegram.WebApp.close();
                        }
                    });
                });
            } else {
                console.error("Telegram Web App API not found.");
            }
        };
    </script>
</body>
</html>
