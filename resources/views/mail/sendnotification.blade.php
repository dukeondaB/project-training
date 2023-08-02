<!DOCTYPE html>
<html>
<head>
    <title>Thông báo đăng ký môn học</title>
</head>
<body>
<p>Xin chào, {{ $studentName }}!</p>
@if (isset($subjectCount))
    <p>Bạn đã đăng ký {{ $subjectCount }} môn học trong khoa của mình.</p>
    <p>Xin hãy đăng ký đủ số lượng môn học để hoàn thành chương trình học.</p>
@else
    <p>Bạn chưa đăng ký môn học nào trong khoa của mình.</p>
    <!-- Nếu bạn muốn hiển thị thông báo khác nếu không có subjectCount -->
@endif
<p>Trân trọng,</p>
<p>Đội ngũ quản lý trường học</p>
</body>
</html>
