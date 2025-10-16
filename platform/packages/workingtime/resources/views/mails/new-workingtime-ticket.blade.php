<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTECH - Thông báo</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f0f2f5; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="700" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 30px; text-align: center; background-color: #cecece;">
                            <img src="{{ asset('public/images/logo.png') }}" alt="Ktech Logo" style="max-width: 180px;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding: 30px 40px 10px 40px; text-align: center;">
                            <h2 style="margin: 0; color: #004a99; text-transform: uppercase;">Xác nhận đơn bổ sung điểm danh</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 10px 40px 30px 40px; color: #333333; font-size: 16px; line-height: 1.6;">
                            <p>Xin chào <strong>{{ $admin->fullname }}</strong>,</p>
                            <p>Dưới đây là thông tin đơn bổ sung điểm danh:</p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
                                <tr>
                                    <td style="padding: 8px 0;"><strong>@lang('Tên nhân viên'):</strong></td>
                                    <td>{{ $ticket->admin?->fullname }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;"><strong>@lang('Ngày bổ sung'):</strong></td>
                                    <td>{{ format_date($ticket->ticket_date) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;"><strong>@lang('Loại bổ sung'):</strong></td>
                                    <td>{{ $ticket->type->description() }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0;"><strong>@lang('Lý do'):</strong></td>
                                    <td>{{ $ticket->reason }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; vertical-align: top;"><strong>@lang('Hình ảnh đính kèm'):</strong></td>
                                    <td>
                                        <img src="{{ asset($ticket->attachment_path) }}" alt="Hình ảnh đính kèm" style="max-width: 100%; border: 1px solid #ddd; border-radius: 4px; margin-top: 10px;">
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top: 30px;">Trân trọng,<br><strong>KTECH</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 12px; color: #777;">
                            Email này được gửi tự động từ hệ thống. Vui lòng không trả lời email này.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
