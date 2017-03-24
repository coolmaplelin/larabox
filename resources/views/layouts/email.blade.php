<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="margin:0; font-family: Avenir, Helvetica, sans-serif;">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f8fa;margin: 0;padding:0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="header" align="center" style="
                            font-family: Avenir, Helvetica, sans-serif;
                            padding: 25px 0;
                        ">
                            @yield('header')
                        </td>
                    </tr>


                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0" style="
                                background-color: #FFFFFF;
                                border-bottom: 1px solid #EDEFF2;
                                border-top: 1px solid #EDEFF2;
                                margin: 0;
                                padding: 0;
                                width: 100%;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                -premailer-width: 100%;"
                            >
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="
                                background-color: #FFFFFF;
                                margin: 0 auto;
                                padding: 0;
                                width: 570px;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                -premailer-width: 570px;
                            ">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell" align="left" style="
                                        font-family: Avenir, Helvetica, sans-serif;
                                        padding: 35px;
                                    ">
                                        @yield('content')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="
                                margin: 0 auto;
                                padding: 0;
                                text-align: center;
                                width: 570px;
                                -premailer-cellpadding: 0;
                                -premailer-cellspacing: 0;
                                -premailer-width: 570px;                            
                            ">
                                <tr>
                                    <td class="content-cell" align="center" style="
                                        font-family: Avenir, Helvetica, sans-serif;
                                        padding: 35px;
                                    ">
                                        <p style="color: #AEAEAE;
                                            font-size: 12px;
                                            text-align: center;"
                                            > © {{ date('Y') }} {{ config('app.name') }}. All rights reserved. 
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
