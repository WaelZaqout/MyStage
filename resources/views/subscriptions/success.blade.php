{{-- resources/views/subscriptions/success.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجاح الاشتراك</title>
    @vite('resources/css/app.css') {{-- إذا تستعمل Vite --}}
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-xl rounded-2xl p-10 text-center w-full max-w-md">

            {{-- أيقونة نجاح --}}
            <div class="flex justify-center mb-6">
                <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"/>
                </svg>
            </div>

            {{-- العنوان --}}
            <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 تم الاشتراك بنجاح</h1>

            {{-- النص --}}
            <p class="text-gray-700 mb-6 leading-relaxed">
                لقد تم تفعيل اشتراكك لمدة <span class="font-semibold">شهر واحد</span>.<br>
                نشكرك على ثقتك بنا ونتمنى لك تجربة موفقة.
            </p>

            {{-- زر الرجوع --}}
            <a href="{{ route('site.home') }}"
               class="inline-block bg-green-500 hover:bg-green-600 text-danger text-lg font-semibold px-6 py-3 rounded-lg shadow-md transition">
                العودة إلى الرئيسية
            </a>
        </div>
    </div>

</body>
</html>
