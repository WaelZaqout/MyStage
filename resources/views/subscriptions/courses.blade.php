{{-- resources/views/subscriptions/success.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجاح الاشتراك</title>
    <style>
        body {
            font-family: "Tahoma", sans-serif;
            background: linear-gradient(to bottom right, #f0fff4, #ffffff, #f0fdf4);
            margin: 0;
            padding: 0;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* أيقونات الخلفية */
        .circle1, .circle2 {
            position: absolute;
            border-radius: 50%;
            opacity: 0.4;
            filter: blur(40px);
        }

        .circle1 {
            width: 150px;
            height: 150px;
            background: #bbf7d0;
            top: -50px;
            right: -50px;
        }

        .circle2 {
            width: 150px;
            height: 150px;
            background: #dcfce7;
            bottom: -50px;
            left: -50px;
        }

        .icon {
            background: #ecfdf5;
            padding: 25px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            color: #047857;
            margin-bottom: 15px;
        }

        p {
            font-size: 18px;
            color: #374151;
            margin-bottom: 30px;
        }

        p span {
            font-weight: bold;
            color: #065f46;
            text-decoration: underline dotted;
        }

        .btn-course {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(to right, #22c55e, #16a34a, #15803d);
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
            transition: all 0.3s ease;
        }

        .btn-course:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(21, 128, 61, 0.4);
            background: linear-gradient(to right, #16a34a, #15803d, #166534);
        }

        .back-link {
            display: block;
            margin-top: 25px;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #15803d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="circle1"></div>
            <div class="circle2"></div>

            {{-- أيقونة نجاح --}}
            <div class="icon">
                <svg class="w-20 h-20 text-green-500" fill="none" stroke="green" width="80" height="80" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>

            <h1>🎉 مبروك! تم الشراء بنجاح</h1>

            <p>
                لقد قمت بشراء كورس
                <span>{{ $course->title }}</span>.<br>
                نتمنى لك رحلة تعليمية ممتعة ومليئة بالإنجاز 🚀
            </p>

            <a href="{{ route('lesson.show', $course->id) }}" class="btn-course">
                📚 ابدأ الكورس الآن
            </a>

            <a href="{{ route('site.home') }}" class="back-link">
                ⬅️ العودة إلى الصفحة الرئيسية
            </a>
        </div>
    </div>
</body>

</html>
