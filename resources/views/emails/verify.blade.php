<!DOCTYPE html>
<html>
    @include('partials.mail-header')
    <body>
        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
            <td align="center" valign="top" id="bodyCell">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                    <td align="center" valign="top" id="templateHeader" background="https://trymyguitar.be/images/electric-guitars.jpg" style="background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:100px; padding-bottom:100px;">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="headerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <div style="text-align: center;">
                                                                    <span style="color:#FFFFFF"><span style="font-size:72px; font-weight: 600;"></span></span>
                                                                </div>
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>
                    <td align="center" valign="top" id="templateBody">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="bodyContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                <h1 style="text-align: center;">Hey {{ $user->first_name }},</h1>
                                                                <p style="text-align: center;">Thanks for registering at Try my guitar! Please click the link below to verify your account.</p>
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                                            <tbody class="mcnButtonBlockOuter">
                                            <tr>
                                            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #2359bd;">
                                                    <tbody>
                                                    <tr>
                                                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 15px;">
                                                        <a class="mcnButton " title="Verify my account" href="{{ route('verify', ['id' => $user->id, 'token' => $user->verification_token]) }}" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Verify my account</a>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>
                    <td align="center" valign="top" id="templateFooter">
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                    <tr>
                                    <td valign="top" class="footerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                            <td class="mcnDividerBlockInner"
                                                    style="min-width: 100%; padding: 10px 18px 25px;">
                                                <table class="mcnDividerContent" border="0" cellpadding="0"
                                                        cellspacing="0" width="100%"
                                                        style="min-width: 100%;border-top: 2px solid #EEEEEE;">
                                                    <tbody>
                                                    <tr>
                                                    <td>
                                                        <span></span>
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                    <tr>
                                                    <td valign="top" width="599" style="width:599px;">
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                            <tr>
                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px; text-align: center;">
                                                                If you didn't register yourself to our website, you can just ignore this mail.
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </table>
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