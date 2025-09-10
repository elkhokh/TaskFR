<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Comment Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #003087; padding: 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">New Comment on Your Post</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="color: #333333; font-size: 16px; line-height: 1.5; margin: 0 0 20px;">Dear User,</p>
                            <p style="color: #333333; font-size: 16px; line-height: 1.5; margin: 0 0 20px;">
                                A new comment has been posted on your content. Below are the details:
                            </p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" border="0" style="background-color: #f9f9f9; border-radius: 4px;">
                                <tr>
                                    <td style="color: #333333; font-size: 16px; font-weight: bold; width: 25%;">User:</td>
                                    <td style="color: #333333; font-size: 16px;">{{ $comment->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #333333; font-size: 16px; font-weight: bold; width: 25%;">Comment:</td>
                                    <td style="color: #333333; font-size: 16px;">{{ $comment->content }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #333333; font-size: 16px; font-weight: bold; width: 25%;">Post:</td>
                                    <td style="color: #333333; font-size: 16px;">{{ $comment->post->title }}</td>
                                </tr>
                            </table>
                            <p style="color: #333333; font-size: 16px; line-height: 1.5; margin: 20px 0;">
                                Thank you for your engagement with our platform.
                            </p>
                            <p style="color: #333333; font-size: 16px; line-height: 1.5; margin: 0;">
                                Best regards,<br>
                                The Platform Team
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f4f4f4; padding: 20px; text-align: center; color: #666666; font-size: 14px;">
                            <p style="margin: 0;">&copy; 2025 Your Platform Name. All rights reserved.</p>
                            <p style="margin: 5px 0;">123 Business Avenue, Suite 100, City, Country</p>
                            <p style="margin: 5px 0;">
                                <a href="#" style="color: #003087; text-decoration: none;">Unsubscribe</a> |
                                <a href="#" style="color: #003087; text-decoration: none;">Contact Us</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
