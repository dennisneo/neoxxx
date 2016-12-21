<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style type="text/css">
        img {
            max-width: 100%;
        }
        body {
            -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
        }
        body {
            background-color: #f6f6f6;
        }
        @media only screen and (max-width: 640px) {
            body {
                padding: 0 !important;
            }
            h1 {
                font-weight: 800 !important; margin: 20px 0 5px !important;
            }
            h2 {
                font-weight: 800 !important; margin: 20px 0 5px !important;
            }
            h3 {
                font-weight: 800 !important; margin: 20px 0 5px !important;
            }
            h4 {
                font-weight: 800 !important; margin: 20px 0 5px !important;
            }
            h1 {
                font-size: 22px !important;
            }
            h2 {
                font-size: 18px !important;
            }
            h3 {
                font-size: 16px !important;
            }
            .container {
                padding: 0 !important; width: 100% !important;
            }
            .content {
                padding: 0 !important;
            }
            .content-wrap {
                padding: 10px !important;
            }
            .invoice {
                width: 100% !important;
            }
        }
    </style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600px" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
            <div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0;" bgcolor="#fff">
                    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                            <meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" />
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#444444;font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; border: none; font-size: 14px; margin: 0;">
                                <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 10px;" valign="top">
                                        <!-- company logo here -->
                                        <img src="<?php echo \Helpers\Html::logoPath(); ?>" />
                                    </td>
                                </tr><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px 0 20px 0;background-color: #FFFFFF;" valign="top">
                                        <div style="margin-bottom:32px">
                                        Hi <?php echo $student->displayName() ?>,
                                        </div>
                                        <div class="message">

                                        </div>
                                        <div>
                                            Username: <?php echo $student->username ?><br />
                                            Password: <?php echo $student->getPassword( $params['pwd'] ); ?>
                                        </div>
                                        <div style="margin-top:64px">
                                            Team NEO
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
                <div style="border-top: #CFCFCF 1px solid;margin-bottom: 18px">&nbsp;</div>

                <div class="footer" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 0px;">
                    <table width="100%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
                                <div style="text-align: center;padding:20px 0 20px 0">
                                    <!--
                                    <a href="https://www.facebook.com/NextChapterVentures" target="_blank">
                                        <img alt="fb" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAACHElEQVR42mNgGAzAPHKanlXkrGabqFkHrKNmvbCOmvkbSP8C4mc2kTP3AMVrzKNmqJJluHXkLG2rqJnbgYb9s4me/R8fBqr5G1qwYlV9/3YFoi0AurwIqPEnIcMxLZv5xSpqVgIRPpjZT6rhaL76ZxU5swyvDwgZYh83939C1dr/GQ0bwdgjdSEOi2bEYI0DQkEUXrji/9OXn/4jg5Ku7biC7qN1xGQpVEuiZu4g5IvDZx78Rwe4LAHjqJnzUJIpMano05cfcMMnLzn+v7B923/v9EX44ueXcehMflhcNBMTqd9+/IJb4pQwj7iEEDnTBhZUB/EpTK3d8H/+urP/f//+A7dk+dZL/5dsuvAfmD/wWxQ5Iw5qyayX+BT2zj/yHxeIKVuN1xJgci4GWwIsGv7gU9g+6+D/D5+////37x/c8K/ffv7/AsTYkjBqcM2qg/nkFzHh+/MXIri88EQ4WlKuhVnyjFaWgDI4JLhApSnNfDIrGhYnNTSzJGyaBdgSs/BZaqDimtqWAM38rufWzQ3P9c6J81dR25KIopUTUcouh4T5CqD6gFqWAM16FVo4RwizqAdWOPjKsLT6jfAi3j52Dp6CcdYfq4iZ3rjrlKhZ5cQUlngtIKZ2BFU4oPqAjFrxJV4fYFRiwAoHVB8QUxoAHfQttmz1xL45x4TIarWA6gNQcQ1sucSCCjtQWQQqKqCNjWhQPkBJplgAAAFjZGqSsFHKAAAAAElFTkSuQmCC"
                                             style="" class="CToWUd" width="24" height="24" />
                                    </a>
                                    -->
                                </div>
                                <div style="border-top: #CFCFCF 1px solid">&nbsp;</div>
                                <div style="text-align: center">
                                    <i>Copyright © <?php echo date('Y') ?> <?php echo env( 'COMPANY_NAME' ) ?> All rights reserved.</i>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    </tr></table></body>
</html>